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
    $token = App\Services\LwApiService::getAccessToken();
    $botNo = "6811630";
    // 末尾にスラッシュを入れないURL
    $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus";

    $response = Http::withToken($token)->post($url, [
        "richmenuName" => "ForestMenuV2", // 'name' ではなく 'richmenuName'
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
                    "label" => "HPを表示",
                    "uri" => "https://www.jforest-chuno.com/"
                ]
            ]
        ]
    ]);

    if ($response->successful()) {
        return "新しいIDが発行されました！: " . $response->json()['richmenuId'];
    }

    return "作成失敗 (" . $response->status() . "): " . $response->body();
});
