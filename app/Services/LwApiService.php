<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;

class LwApiService
{
    public static function getAccessToken()
    {
        $clientId = 'WPcmfuIP1CiGM4ahu_eZ';
        $clientSecret = 'Rmm9WTCneq';
        $serviceAccount = 'd1gwz.serviceaccount@works-287419';
        $privateKeyPath = storage_path('app/certs/private_key.key');

        if (!file_exists($privateKeyPath)) {
            throw new \Exception("秘密鍵ファイルがありません: " . $privateKeyPath);
        }

        $privateKey = file_get_contents($privateKeyPath);
        $now = time();
        $payload = [
            "iss" => $clientId,
            "sub" => $serviceAccount,
            "iat" => $now,
            "exp" => $now + 3600
        ];

        $assertion = JWT::encode($payload, $privateKey, 'RS256');

        $response = Http::asForm()->post("https://auth.worksmobile.com/oauth2/v2.0/token", [
            "assertion" => $assertion,
            "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer",
            "client_id" => $clientId,
            "client_secret" => $clientSecret,
            "scope" => "bot"
        ]);

        if (!$response->successful()) {
            throw new \Exception("トークン取得失敗: " . $response->body());
        }

        return $response->json()['access_token'];
    }

    public static function sendAttendanceSelection($userId)
    {
        $token = self::getAccessToken();
        $botNo = "6811630";
        // ✅ 一旦このURL(v1.0形式)で通るか再確認
        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/users/{$userId}/messages";

        $options = [
            ['label' => '出勤', 'val' => '1.0/出勤'],
            ['label' => '有給', 'val' => '1.0/有給'],
            ['label' => '欠勤', 'val' => '0.0/欠勤'],
        ];

        $items = array_map(function ($opt) {
            return [
                "action" => [
                    "type" => "message",
                    "label" => $opt['label'],
                    "text" => "【打刻】" . $opt['val']
                ]
            ];
        }, $options);

        $response = Http::withToken($token)->post($url, [
            "content" => [
                "type" => "text",
                "text" => "本日の出勤内訳を選択してください。"
            ],
            "quickReply" => [
                "items" => $items
            ]
        ]);

        // ✅ デバッグログ：ここが何と返ってくるかだけ見たい
        \Log::info("API Status: " . $response->status());
        \Log::info("API Body: " . $response->body());

        return $response;
    }

    public static function sendSimpleText($userId, $text)
    {
        $token = self::getAccessToken();
        $botNo = "6811630";
        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/users/{$userId}/messages";

        return Http::withToken($token)->post($url, [
            "content" => [
                "type" => "text",
                "text" => $text
            ]
        ]);
    }
}
