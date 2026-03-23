<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LwApiService;
use App\Models\LwAttendance;
use Illuminate\Support\Facades\Log;

class LwAttendanceController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $content = $request->input('content');
        $source = $request->input('source');

        if (!$content || !$source) return response()->json(['status' => 'ignore']);

        $userId = $source['userId'];
        $text = $content['text'] ?? '';

        // 1. 「出勤」という文字に反応してクイッキリプライを出す
        if ($text === '出勤' || $text === '記録') {
            LwApiService::sendAttendanceSelection($userId);
            return response()->json(['status' => 'ok']);
        }

        // 2. ボタンタップで飛んできた「【打刻】1.0/出勤」を保存
        if (str_starts_with($text, '【打刻】')) {
            $rawPayload = str_replace('【打刻】', '', $text);
            $parts = explode('/', $rawPayload); // [0]=>1.0, [1]=>出勤

            if (count($parts) === 2) {
                try {
                    LwAttendance::updateOrCreate(
                        [
                            'lw_user_id' => $userId,
                            'work_date'  => now()->toDateString(), // 今日の日付
                        ],
                        [
                            'category'   => $parts[1], // "出勤"
                            'work_value' => $parts[0], // 1.0
                            'user_name'  => 'LINE WORKS User', // 必要ならProfile APIで取得
                        ]
                    );

                    LwApiService::sendSimpleText($userId, "✅ 記録しました！\n区分: {$parts[1]}\n数値: {$parts[0]}");
                } catch (\Exception $e) {
                    Log::error("DB保存失敗: " . $e->getMessage());
                    LwApiService::sendSimpleText($userId, "⚠️ 保存に失敗しました。管理者へ連絡してください。");
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
