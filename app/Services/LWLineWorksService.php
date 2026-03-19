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

        $url = 'https://auth.worksmobile.com/oauth2/v2.0/token';

        $response = Http::asForm()->post($url, [
            'grant_type'    => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'     => $jwt,
            'client_id'     => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'scope'         => 'bot', // ここは 'bot' で合っています
        ]);

        // 【デバッグ】404や401などのエラー時に中身を強制表示
        if ($response->failed()) {
            dd([
                'URL' => $url,
                'Status' => $response->status(),
                'Body' => $response->body(), // json()ではなくbody()で生データを見る
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
