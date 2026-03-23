<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LwApiService
{
    // アクセストークン取得メソッドは既存のものを使用

    public static function sendAttendanceSelection($userId)
    {
        $token = self::getAccessToken();
        $botNo = "6811630";
        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/users/{$userId}/messages";

        // ラベルと、実際にDBに振り分ける値のセット
        $options = [
            ['label' => '1.0 出勤',      'val' => '1.0/出勤'],
            ['label' => '1.0 有給',      'val' => '1.0/有給'],
            ['label' => '1.0 特休',      'val' => '1.0/特休'],
            ['label' => '1.0 出勤-有給', 'val' => '1.0/出勤-有給'],
            ['label' => '0.5 出勤-欠勤', 'val' => '0.5/出勤-欠勤'],
            ['label' => '0.5 有給-欠勤', 'val' => '0.5/有給-欠勤'],
            ['label' => '0.0 欠勤',      'val' => '0.0/欠勤'],
        ];

        $items = [];
        foreach ($options as $opt) {
            $items[] = [
                "action" => [
                    "type" => "message",
                    "label" => $opt['label'],
                    "text" => "【打刻】" . $opt['val'] // 例: 【打刻】1.0/出勤
                ]
            ];
        }

        return Http::withToken($token)->post($url, [
            "content" => [
                "type" => "text",
                "text" => "本日の出勤内訳を選択してください。"
            ],
            "quickReply" => ["items" => $items]
        ]);
    }
}
