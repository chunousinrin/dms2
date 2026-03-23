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


Route::get('/upload-resize-fix', function () {
    try {
        $token = App\Services\LwApiService::getAccessToken();
        $botNo = "6811630";
        $richMenuId = "rm-2205961";
        $imagePath = public_path('images/menu.png');

        // 1. 画像を読み込んで 2500x1686 にリサイズする
        $source = imagecreatefrompng($imagePath);
        $trueWidth = 2500;
        $trueHeight = 1686;
        $target = imagecreatetruecolor($trueWidth, $trueHeight);

        // 背景を白で塗りつぶす
        $white = imagecolorallocate($target, 255, 255, 255);
        imagefill($target, 0, 0, $white);

        // 元画像をアスペクト比を無視して引き伸ばす（または余白を作る）
        imagecopyresampled($target, $source, 0, 0, 0, 0, $trueWidth, $trueHeight, imagesx($source), imagesy($source));

        // 2. 一時ファイルとして保存
        $tempFile = tempnam(sys_get_temp_dir(), 'richmenu');
        imagepng($target, $tempFile);

        $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

        // 3. アップロード実行
        $response = Http::withToken($token)
            ->attach('file', file_get_contents($tempFile), 'menu.png', ['Content-Type' => 'image/png'])
            ->post($url);

        // 後片付け
        imagedestroy($source);
        imagedestroy($target);
        unlink($tempFile);

        if ($response->successful()) {
            return "【歓喜】サイズを強制修正してアップロード成功！ /api/activate-menu を叩いてください！";
        }

        return "Status: " . $response->status() . "<br>詳細: " . $response->body();
    } catch (\Exception $e) {
        return "エラー: " . $e->getMessage();
    }
});
