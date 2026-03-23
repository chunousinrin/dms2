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
    $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus";

    $response = Http::withToken($token)->post($url, [
        "name" => "Forest Menu New",
        "size" => ["width" => 2500, "height" => 1686], // サイズ指定
        "areas" => [
            [
                "bounds" => ["x" => 0, "y" => 0, "width" => 2500, "height" => 1686],
                "action" => ["type" => "uri", "label" => "HP", "uri" => "https://www.jforest-chuno.com/"]
            ]
        ]
    ]);

    return $response->json(); // 新しいIDをメモしてください
});
