<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;

class LwApiService
{
    public static function getAccessToken()
    {
        // 1. もう Config や .env は見ない！ここに直接書く
        $clientId = 'あなたのClient_ID'; // ←実際の値をここに貼る
        $clientSecret = 'あなたのClient_Secret'; // ←実際の値をここに貼る
        $serviceAccount = 'あなたのService_Account'; // ←実際の値をここに貼る

        // 2. 秘密鍵のパス（先ほどの config/services.php のパスに合わせる）
        $privateKeyPath = storage_path('app/private_key.key');

        // --- ここから下はチェックなしで突き進む ---
        if (!file_exists($privateKeyPath)) {
            throw new \Exception("秘密鍵ファイルがありません: " . $privateKeyPath);
        }

        $privateKey = file_get_contents($privateKeyPath);

        // JWTの生成（以下、前回と同じ）
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
            "scope" => "bot" // 一旦 'bot' だけにしてみる
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

        // ✅ 修正：公式の 2.0 1:1メッセージ送信エンドポイント
        // 「www.worksapis.com」ではなく「www.worksapis.com/v2/bot/」がベースです
        $url = "https://www.worksapis.com/v2/bot/{$botId}/users/{$userId}/messages";

        $options = [
            ['label' => '1.0 出勤', 'val' => '1.0/出勤'],
            ['label' => '1.0 有給', 'val' => '1.0/有給'],
            ['label' => '1.0 特休', 'val' => '1.0/特休'],
            ['label' => '1.0 出勤-有給', 'val' => '1.0/出勤-有給'],
            ['label' => '0.5 出勤-欠勤', 'val' => '0.5/出勤-欠勤'],
            ['label' => '0.5 有給-欠勤', 'val' => '0.5/有給-欠勤'],
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

        // 送信
        $response = Http::withToken($token)->post($url, [
            "content" => [
                "type" => "text",
                "text" => "本日の出勤内訳を選択してください。"
            ],
            "quickReply" => [
                "items" => $items
            ]
        ]);

        \Log::info("LINE WORKS API Status: " . $response->status());
        \Log::info("LINE WORKS API Response: " . $response->body());

        return $response;
    }
}
