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

Route::get('/create-menu', function () {
    try {
        echo "1. 処理開始...<br>";
        $token = App\Services\LwApiService::getAccessToken();
        $botNo = env('LW_BOT_NO');
        $url = "https://www.worksapis.com/v1.0/bots/" . $botNo . "/richmenus";

        $response = Http::withToken($token)
            ->post($url, [
                "size" => [
                    "width" => 2500,
                    "height" => 1686,
                ],
                "selected" => true,
                "richmenuName" => "勤怠メニュー", // 'name' から 'richmenuName' に変更
                "areas" => [
                    [
                        "bounds" => [
                            "x" => 0,
                            "y" => 0,
                            "width" => 2500,
                            "height" => 1686
                        ],
                        "action" => [
                            "type" => "message",
                            "label" => "出勤入力",
                            "text" => "出勤入力"
                        ]
                    ]
                ]
            ]);

        if ($response->failed()) {
            return "APIエラー詳細: " . $response->body();
        }

        // ついにIDが返ってくるはず！
        return "成功！ Rich Menu ID: " . $response->json('richmenuId'); // 'richMenuId' (Mが大文字) の可能性もあるため注意

    } catch (\Exception $e) {
        return "例外発生: " . $e->getMessage();
    }
});
