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
        //\App\Services\LwApiService::debugToken();

        $userId = $request->input('source.accountId');
        $text   = $request->input('content.text');

        if (!$userId || !$text) {
            return response()->json(['status' => 'ignore']);
        }

        // ① 出勤でクイックリプライ
        if ($text === '出勤' || $text === '記録') {
            LwApiService::sendAttendanceSelection($userId);
            return response()->json(['status' => 'ok']);
        }

        // ② 打刻処理
        if (str_starts_with($text, '【打刻】')) {

            $rawPayload = str_replace('【打刻】', '', $text);
            $parts = explode('/', $rawPayload);

            if (count($parts) === 2) {
                try {
                    LwAttendance::updateOrCreate(
                        [
                            'lw_user_id' => $userId,
                            'work_date'  => now()->toDateString(),
                        ],
                        [
                            'category'   => $parts[1],
                            'work_value' => $parts[0],
                            'user_name'  => 'LINE WORKS User',
                        ]
                    );

                    LwApiService::sendSimpleText(
                        $userId,
                        "✅ 記録しました！\n区分: {$parts[1]}\n数値: {$parts[0]}"
                    );
                } catch (\Exception $e) {
                    \Log::error("DB保存失敗: " . $e->getMessage());

                    LwApiService::sendSimpleText(
                        $userId,
                        "⚠️ 保存に失敗しました"
                    );
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
    public function testSend()
    {
        return LwApiService::sendAttendanceSelection("wo.57832@works-287419");
    }
}
