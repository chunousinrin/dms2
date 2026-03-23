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


Route::get('/upload-final-qiita-fix', function () {
    try {
        $token = App\Services\LwApiService::getAccessToken();
        $botNo = "6811630";
        $richMenuId = "rm-2205959"; // 固定したID
        $imagePath = public_path('images/menu.png');

        if (!file_exists($imagePath)) {
            return "画像がないです！ public/images/menu.png を確認してください。";
        }

        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

        // Qiitaの記事と公式の挙動を合わせた「勝負のパケット」
        $response = Http::withToken($token)
            ->attach(
                'file',                       // ← キー名は絶対これ
                file_get_contents($imagePath), // 中身
                'menu.png'                    // ← ファイル名を明示（これが大事！）
            )
            ->post($url);

        if ($response->successful()) {
            return "【大・勝・利！！】ついに画像が乗りました！ /api/activate-menu を叩いてください！";
        }

        // 400が出るなら、詳細を表示
        return "Status: " . $response->status() . "<br>詳細: " . $response->body();
    } catch (\Exception $e) {
        return "エラー: " . $e->getMessage();
    }
});
