<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lw_attendances; // 事前にModelを作成してください
use Illuminate\Support\Facades\Log;

class LwAttendanceController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // 1. 届いたデータそのものを出力
        \Log::info('Full Request Data:', $request->all()); // 全データ出力

        // 2. typeがpostbackになっているかチェック
        $type = $request->json('type'); // または $request->input('type')

        if ($type !== 'postback') {
            \Log::warning('Received type: ' . ($type ?: 'NULL or EMPTY'));
            return response()->json(['status' => 'ignored', 'received_type' => $type]);
        }

        try {
            // 3. dataの中身をパース
            $rawData = $request->input('data');
            \Log::info('Raw Data String:', ['data' => $rawData]);

            $data = json_decode($rawData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('JSON Decode Error: ' . json_last_error_msg());
            }

            // 4. 保存実行直前のデータを確認
            \Log::info('Data to Save:', [
                'lw_user_id' => $request->input('source')['userId'] ?? 'MISSING',
                'work_date'  => $data['date'] ?? 'MISSING',
                'category'   => $data['cat'] ?? 'MISSING',
                'work_value' => $data['val'] ?? 'MISSING',
            ]);

            $record = lw_attendances::updateOrCreate(
                [
                    'lw_user_id' => $request->input('source')['userId'],
                    'work_date'  => $data['date'] ?? now()->format('Y-m-d'),
                ],
                [
                    'user_name'  => $request->input('user_name', 'Unknown'),
                    'category'   => $data['cat'],
                    'work_value' => $data['val'],
                ]
            );

            \Log::info('Save Success! ID: ' . $record->id);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error('LwAttendance Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}
