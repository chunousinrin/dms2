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


Route::get('/upload-final-retry', function () {
    $token = App\Services\LwApiService::getAccessToken();
    $botNo = "6811630";
    $richMenuId = "rm-2205959";
    $imagePath = public_path('images/menu.png');

    $response = Http::withToken($token)
        ->attach('file', file_get_contents($imagePath), 'menu.png')
        ->post("https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image");

    return "Status: " . $response->status() . " / Body: " . $response->body();
});
