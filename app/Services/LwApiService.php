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
        $botId = "6811630";

        // ✅ 2.0の正式URL（単数形 bot / 複数形 users）
        $url = "https://www.worksapis.com/v2/bot/{$botId}/users/{$userId}/messages";

        $options = [
            ['label' => '1.0 出勤', 'val' => '1.0/出勤'],
            ['label' => '1.0 有給', 'val' => '1.0/有給'],
            ['label' => '0.0 欠勤', 'val' => '0.0/欠勤'],
        ];

        $items = [];
        foreach ($options as $opt) {
            $items[] = [
                "action" => [
                    "type" => "message",
                    "label" => $opt['label'],
                    "text" => "【打刻】" . $opt['val']
                ]
            ];
        }

        // ✅ フォーラムの指摘通り、Headersを明示的に指定
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post($url, [
            "content" => [
                "type" => "text",
                "text" => "本日の出勤内訳を選択してください。"
            ],
            "quickReply" => [
                "items" => $items
            ]
        ]);

        \Log::info("API Status: " . $response->status());
        \Log::info("API Body: " . $response->body());

        return $response;
    }
}
