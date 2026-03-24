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
        $clientId = 'WPcmfuIP1CiGM4ahu_eZ'; // ←実際の値をここに貼る
        $clientSecret = 'Rmm9WTCneq'; // ←実際の値をここに貼る
        $serviceAccount = 'd1gwz.serviceaccount@works-287419'; // ←実際の値をここに貼る

        // 2. 秘密鍵のパス（先ほどの config/services.php のパスに合わせる）
        $privateKeyPath = storage_path('app/certs/private_key.key');

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

        // 🚨 重要：Developer Console の「Bot」メニューにある「Bot No.」を再確認してください。
        // もし「6811630」で404なら、その数字の前後に空白がないか、
        // あるいは別の「ID」という項目がないか見てください。
        $botId = "6811630";

        // ✅ API 2.0 公式ドキュメント通りの1:1送信URL
        $url = "https://apis.worksmobile.com/v2/bot/6811630/users/{$userId}/messages";

        $options = [
            ['label' => '出勤', 'val' => '1.0/出勤'],
            ['label' => '有給', 'val' => '1.0/有給'],
            ['label' => '欠勤', 'val' => '0.0/欠勤'],
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

        // ✅ Guzzle(Http)のpostメソッドで、ヘッダーを確実に固定して送る
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post($url, [
            "content" => [
                "type" => "text",
                "text" => "本日の出刻内訳を選択してください。"
            ],
            "quickReply" => [
                "items" => $items
            ]
        ]);

        \Log::info("API Status: " . $response->status());
        \Log::info("API Body: " . $response->body());

        return $response;
    }

    /**
     * シンプルなテキスト送信
     */
    public static function sendSimpleText($userId, $text)
    {
        $token = self::getAccessToken();
        $botNo = "6811630";
        $url = "https://apis.worksmobile.com/v2/bot/6811630/users/{$userId}/messages";

        return Http::withToken($token)->post($url, [
            "content" => [
                "type" => "text",
                "text" => $text
            ]
        ]);
    }
    public static function debugToken()
    {
        $token = self::getAccessToken();
        $botId = "6811630";

        // ✅ メッセージ送信より単純な「Bot情報取得」API
        $url = "https://apis.worksmobile.com/v2/bot/6811630/users/{$userId}/messages";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($url);

        \Log::info("DEBUG Token Status: " . $response->status());
        \Log::info("DEBUG Token Body: " . $response->body());

        return $response->status();
    }
}
