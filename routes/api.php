<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LwAttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/webhook', [LwAttendanceController::class, 'handleWebhook']);


use Illuminate\Support\Facades\Http;
use App\Services\LwApiService;
use Illuminate\Support\Facades\Log;

Route::get('/create-new-menu', function () {
    try {
        $token = App\Services\LwApiService::getAccessToken();
        $botNo = "6811630";
        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus";

        // 数値は「"」で囲まず、純粋な数値として送る
        $payload = [
            "richmenuName" => "ForestMenu_V3",
            "size" => [
                "width" => 2500,
                "height" => 1686
            ],
            "areas" => [
                [
                    "bounds" => [
                        "x" => 0,
                        "y" => 0,
                        "width" => 2500,
                        "height" => 1686
                    ],
                    "action" => [
                        "type" => "uri",
                        "label" => "HPを開く",
                        "uri" => "https://www.jforest-chuno.com/"
                    ]
                ]
            ]
        ];

        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $payload);

        if ($response->successful()) {
            $data = $response->json();
            return "【成功】新しいIDが発行されました！ ID: " . $data['richmenuId'];
        }

        return "作成失敗 (" . $response->status() . "): " . $response->body();
    } catch (\Exception $e) {
        return "例外エラー: " . $e->getMessage();
    }
});


Route::get('/upload-simple', function () {
    $token = App\Services\LwApiService::getAccessToken();
    $botNo = "6811630";
    $richMenuId = "rm-2205961"; // 作成済みのID

    $response = Http::withToken($token)
        ->attach(
            'file',
            file_get_contents(public_path('images/menu.png')),
            'menu.png'
        )
        ->post("https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image");

    return $response->successful() ? "成功！" : "失敗：" . $response->body();
});
