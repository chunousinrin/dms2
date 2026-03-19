<?php

namespace App\Services;

if (!defined('CURL_SSLVERSION_TLSv1_2')) define('CURL_SSLVERSION_TLSv1_2', 6);

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LWLineWorksService
{
    protected $config;
    protected $accessToken;

    public function __construct()
    {
        $this->config = config('lw_lineworks');
    }

    protected function getAccessToken()
    {
        if ($this->accessToken) return $this->accessToken;

        $now = time();
        $privateKey = file_get_contents(storage_path('app/lineworks/private_key.key'));

        $payload = [
            "iss" => $this->config['client_id'],
            "sub" => $this->config['service_account'],
            "iat" => $now,
            "exp" => $now + 3600
        ];

        $jwt = JWT::encode($payload, $privateKey, 'RS256');

        $response = Http::asForm()->post('https://auth.worksmobile.com/oauth2/v2.0/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt,
            'client_id'  => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'scope'      => 'bot'
        ]);

        // 【ここを追加】エラーの中身を画面に表示して停止させる
        if ($response->failed() || !isset($response->json()['access_token'])) {
            dd([
                'HTTPステータス' => $response->status(),
                'LINEWORKSからの返答' => $response->json(),
                '使用した設定' => $this->config
            ]);
        }

        $this->accessToken = $response->json()['access_token'];
        return $this->accessToken;
    }

    public function sendTextMessage($userId, $text)
    {
        return $this->sendRequest($userId, [
            'content' => ['type' => 'text', 'text' => $text]
        ]);
    }

    public function sendFlexibleMessage($userId, $flexContent)
    {
        return $this->sendRequest($userId, [
            'content' => [
                'type' => 'flexible',
                'altText' => '勤怠報告メニュー',
                'contents' => $flexContent
            ]
        ]);
    }

    protected function sendRequest($userId, $body)
    {
        $token = $this->getAccessToken();
        $botNo = $this->config['bot_no'];
        $url = "https://www.worksmobile.com/jp/message/v1/bot/{$botNo}/users/{$userId}/messages";
        return Http::withToken($token)->post($url, $body)->json();
    }
}
