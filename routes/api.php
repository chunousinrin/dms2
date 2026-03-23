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
    $botNo = "6811630";
    $richMenuId = "rm-2205961";

    $imagePath = public_path('images/menu.png');
    $binary = file_get_contents($imagePath);

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'image/png', // ← これが必須
    ])->withBody(
        $binary,
        'image/png' // ← これも必要
    )->post("https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image");

    return $response->successful() ? "成功！" : "失敗：" . $response->body();
});
