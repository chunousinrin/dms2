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

Route::get('/upload-simple', function () {
    $token = App\Services\LwApiService::getAccessToken();
    $apiId = config('lineworks.api_id');
    $botId = config('lineworks.bot_id');
    $richMenuId = "rm-2205961";

    // ① 画像アップロード（resourceId を取得）
    $binary = file_get_contents(public_path('images/menu.png'));

    $upload = Http::withHeaders([
        'consumerKey' => config('lineworks.consumer_key'),
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'image/png',
    ])->withBody($binary, 'image/png')
        ->post("https://apis.worksmobile.com/r/{$apiId}/message/v1/content");

    if (!$upload->successful()) {
        return "画像アップロード失敗：" . $upload->body();
    }

    $resourceId = $upload['resourceId'];

    // ② リッチメニューに画像を紐付け
    $response = Http::withHeaders([
        'consumerKey' => config('lineworks.consumer_key'),
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'application/json',
    ])->post("https://apis.worksmobile.com/r/{$apiId}/message/v1/bot/{$botId}/richmenu/{$richMenuId}/content", [
        'resourceId' => $resourceId
    ]);

    return $response->successful() ? "成功！" : "失敗：" . $response->body();
});



Route::get('/upload-simplex', function () {
    $token = App\Services\LwApiService::getAccessToken();
    $apiId = config('lineworks.api_id');
    $botId = config('lineworks.bot_id');
    $richMenuId = "rm-2205961";

    // ① 画像アップロード
    $binary = file_get_contents(public_path('images/menu.png'));

    $upload = Http::withHeaders([
        'consumerKey' => config('lineworks.consumer_key'),
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'image/png',
    ])->withBody($binary, 'image/png')
        ->post("https://apis.worksmobile.com/r/{$apiId}/message/v1/content");

    dd($upload->body()); // ← まずこれを確認
});
