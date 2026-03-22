<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LwAttendance; // 事前にModelを作成してください
use Illuminate\Support\Facades\Log;

class LwAttendanceController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // LINE WORKSからのデータを取得
        $content = $request->input('content');
        $source = $request->input('source');

        // ボタン(postback)イベントのみ処理
        if ($request->input('type') !== 'postback') {
            return response()->json(['status' => 'ignored']);
        }

        try {
            // postbackデータ（JSON文字列を想定）をデコード
            // 例: {"date":"2026-03-23", "cat":"出勤-有給", "val":1.0}
            $data = json_decode($request->input('data'), true);

            LwAttendance::updateOrCreate(
                [
                    'lw_user_id' => $source['userId'],
                    'work_date'  => $data['date'] ?? now()->format('Y-m-d'),
                ],
                [
                    'user_name'  => $request->input('user_name', 'Unknown'),
                    'category'   => $data['cat'],
                    'work_value' => $data['val'],
                ]
            );

            // ここでLINE WORKS側に「記録完了」のメッセージを返す処理(Messaging API)を呼ぶのが理想です

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('LwAttendance Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}
