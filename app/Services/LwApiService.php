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

        // ✅ ここが重要（aud追加）
        $payload = [
            "iss" => $clientId,
            "sub" => $serviceAccount,
            "iat" => $now,
            "exp" => $now + 3600,
            "aud" => "https://auth.worksmobile.com/oauth2/v2.0/token"
        ];

        $jwt = JWT::encode($payload, $privateKey, 'RS256');

        $response = Http::asForm()->post(
            "https://auth.worksmobile.com/oauth2/v2.0/token",
            [
                "assertion" => $jwt,
                "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer",
                "client_id" => $clientId,
                "client_secret" => $clientSecret,

                // ✅ スコープ完全一致
                "scope" => "bot bot.message bot.read user.read"
            ]
        );

        // 🔍 デバッグログ
        \Log::info('TOKEN STATUS: ' . $response->status());
        \Log::info('TOKEN BODY: ' . $response->body());

        if (!$response->successful()) {
            throw new \Exception("トークン取得失敗: " . $response->body());
        }

        $json = $response->json();

        if (!isset($json['access_token'])) {
            throw new \Exception("アクセストークンなし: " . json_encode($json));
        }

        return $json['access_token'];
    }

    public static function sendAttendanceSelection($userId)
    {
        $token = self::getAccessToken();
        $botId = "6811673";

        $url = "https://apis.worksmobile.com/v1.0/bots/{$botId}/messages";

        $options = [
            ['label' => '1.0 出勤',      'val' => '1.0/出勤'],
            ['label' => '1.0 有給',      'val' => '1.0/有給'],
            ['label' => '1.0 特休',      'val' => '1.0/特休'],
            ['label' => '1.0 出勤-有給', 'val' => '1.0/出勤-有給'],
            ['label' => '0.5 出勤-欠勤', 'val' => '0.5/出勤-欠勤'],
        ];

        $items = array_map(function ($opt) {
            return [
                "type" => "action",
                "action" => [
                    "type" => "message",
                    "label" => $opt['label'],
                    "text" => "【打刻】" . $opt['val']
                ]
            ];
        }, $options);

        $payload = [
            "accountId" => $userId, // ← 必ず user@works-xxxxx 形式
            "content" => [
                "type" => "text",
                "text" => "本日の出勤内訳を選択してください。",
                "quickReply" => [
                    "items" => $items
                ]
            ]
        ];

        $response = Http::withToken($token)
            ->withHeaders([
                "Content-Type" => "application/json"
            ])
            ->post($url, $payload);

        \Log::info('SEND STATUS: ' . $response->status());
        \Log::info('SEND BODY: ' . $response->body());

        return $response;
    }

    /**
     * シンプルなテキスト送信
     */
    public static function sendSimpleText($userId, $text)
    {
        $token = self::getAccessToken();
        $botId = "6811673";

        $url = "https://apis.worksmobile.com/v1.0/bots/{$botId}/messages";

        return Http::withToken($token)->post($url, [
            "accountId" => $userId,
            "content" => [
                "type" => "text",
                "text" => $text
            ]
        ]);
    }

    public static function debugToken()
    {
        $token = self::getAccessToken();
        $botId = "6811673";

        // ✅ URLに $userId を含めない「Bot詳細取得」API
        // これで 200 OK が出れば、IDとトークンは正しいことが証明されます
        $url = "https://apis.worksmobile.com/v2/bots/{$botId}";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($url);

        \Log::info("DEBUG Token Status: " . $response->status());
        \Log::info("DEBUG Token Body: " . $response->body());

        return $response->status();
    }
}
