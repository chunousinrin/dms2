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

Route::get('/create-menu', function () {
    try {
        $token = LwApiService::getAccessToken();

        $response = Http::withToken($token)
            ->post("https://www.line-works.com/jp/reference/messaging-api/v2/rich-menus", [
                "width" => 2500,
                "height" => 1686,
                "selected" => true,
                "name" => "勤怠メニュー",
                "areas" => [
                    [
                        "bounds" => ["x" => 0, "y" => 0, "width" => 2500, "height" => 1686],
                        "action" => [
                            "type" => "message",
                            "label" => "出勤入力",
                            "text" => "出勤入力"
                        ]
                    ]
                ]
            ]);

        // 結果を画面に表示
        return $response->json();
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});
