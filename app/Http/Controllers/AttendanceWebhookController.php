<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $userId = $request->input('source.userId'); // 誰が
        $data = $request->input('content.postback'); // どのデータを送ったか (value=1.0&status=出勤)

        // クエリ文字列をパース
        parse_str($data, $params);

        if (isset($params['status'])) {
            // データベースに保存
            Attendance::updateOrCreate(
                ['line_works_id' => $userId, 'work_date' => now()->toDateString()],
                ['status' => $params['status'], 'value' => $params['value']]
            );

            // 完了した旨を返信する処理（Messaging APIを叩く）をここに記述
            return response()->json(['status' => 'success']);
        }

        // 「その他」が押された場合は、別のボタンメニューを返信
        if ($params['menu'] === 'others') {
            // 半日単位のメニューを送信する関数などを呼ぶ
        }
    }
}
