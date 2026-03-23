<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LwAttendance; // モデル名を修正
use Illuminate\Support\Facades\Log;

class LwAttendanceController extends Controller
{
    public function handleWebhook(Request $request)
    {

        $rawBody = $request->getContent();
        // まず、届いた生の文字列を無条件でログに取る（これが一番大事！）
        Log::info('Raw Webhook Body: ' . $rawBody);

        $allData = json_decode($rawBody, true);

        // ★ ここにチェックコードを入れます ★
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON Decode Error: ' . json_last_error_msg());
            Log::error('Invalid Body Content: ' . $rawBody); // 壊れた中身をログに残す
            return response()->json([
                'status' => 'error',
                'reason' => json_last_error_msg()
            ], 400); // ここで400を返して終了させる
        }

        // ここから下は、JSONが正しかった場合のみ実行される
        if (($allData['type'] ?? null) !== 'postback') {
            return response()->json(['status' => 'ignored']);
        }

        try {
            $postbackData = json_decode($allData['data'] ?? '{}', true);

            $lwUserId = $allData['source']['userId'] ?? null;
            // 日付が指定されていない場合は今日の日付を入れる
            $workDate = $postbackData['date'] ?? now()->format('Y-m-d');

            // データベース保存実行 (既存データがあれば更新、なければ作成)
            $record = LwAttendance::updateOrCreate(
                [
                    'lw_user_id' => $lwUserId,
                    'work_date'  => $workDate,
                ],
                [
                    'user_name'  => $allData['user_name'] ?? 'LINE WORKS User',
                    'category'   => $postbackData['cat'] ?? '未分類',
                    'work_value' => (float)($postbackData['val'] ?? 0.0),
                ]
            );

            Log::info("Success: Saved LwAttendance ID {$record->id} for User {$lwUserId}");

            return response()->json(['status' => 'success', 'id' => $record->id]);
        } catch (\Exception $e) {
            Log::error('LwAttendance Save Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            // どんな文字列が届いて、なぜ失敗したかログに出す
            Log::error('JSON Decode Error: ' . json_last_error_msg());
            Log::error('Received Invalid Body: ' . $rawBody);
            return response()->json(['status' => 'error', 'reason' => json_last_error_msg()], 400);
        }
    }
}
