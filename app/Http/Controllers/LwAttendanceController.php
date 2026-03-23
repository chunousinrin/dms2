<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LwApiService;
use App\Models\LwAttendance;

class LwAttendanceController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $content = $request->input('content');
        $source = $request->input('source');
        if (!$content || !$source) return response()->json(['status' => 'ignore']);

        $userId = $source['userId'];
        $text = $content['text'] ?? '';

        // 1. トリガーワードの処理
        if ($text === '出勤' || $text === '記録') {
            LwApiService::sendAttendanceSelection($userId);
            return response()->json(['status' => 'ok']);
        }

        // 2. 打刻データの保存処理
        if (str_starts_with($text, '【打刻】')) {
            // "【打刻】1.0/出勤-有給" -> "1.0/出勤-有給"
            $rawPayload = str_replace('【打刻】', '', $text);
            $parts = explode('/', $rawPayload); // [0]=>1.0, [1]=>出勤-有給

            if (count($parts) === 2) {
                try {
                    LwAttendance::updateOrCreate(
                        [
                            'lw_user_id' => $userId,
                            'work_date'  => now()->toDateString(), // 今日の日付
                        ],
                        [
                            'work_value' => $parts[0], // 1.0
                            'category'   => $parts[1], // 出勤-有給
                            // 'user_name' => $userName, // 必要に応じてProfile APIから取得
                        ]
                    );

                    LwApiService::sendSimpleText($userId, "✅ 記録完了しました！\n日付: " . now()->format('m/d') . "\n区分: {$parts[1]} ({$parts[0]})");
                } catch (\Exception $e) {
                    // Unique制約エラー等のハンドリング
                    LwApiService::sendSimpleText($userId, "⚠️ 記録に失敗しました。既に今日データが存在するか、システムエラーです。");
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
