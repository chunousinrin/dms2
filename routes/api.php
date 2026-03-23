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


Route::get('/get-token', function () {
    try {
        // あなたが作った LwApiService を使ってトークンを生成
        $token = App\Services\LwApiService::getAccessToken();
        return "これをコピーしてください：<br><br><textarea style='width:100%;height:100px;'>" . $token . "</textarea>";
    } catch (\Exception $e) {
        return "エラー発生: " . $e->getMessage();
    }
});



Route::get('/upload-final-check', function () {
    // 1. 手動でコピーした値をここに貼り付け（前後にスペースがあってもtrimで消します）
    $rawToken = "jp2AAABK8+dcEf1P6LpiIIn2XgReTfhAkz8XoC5UooLf8nTb8+fnsM93QbQmr82JGuBJz3AAtv+1/CA5IEvsnOaZCN0pKAenTnhE+FdvaTcy8/noTukKWrMVRR+NprecuDs6mx4wZM0iW/muqyxipguj62gJELSDaLtw5Cksut9oQk0cibaZrrTTVVHfIqVPbvpCdWMal3Jv6VXIw4wg/LTvO/+cIhgPBh4rV2JybAZdYa0ZoMobgWIkEOLM9bbi0T2qXj1lTaL3kMG7vSf8r0Fow4Fbf8eM1bo9FKIGRbKF8FUtVv3v2ZtHgC6prFAqXm2WB1Dofovv8gcblLIMqeOM7MoA3/zG0plZRKoQsI2Ax+S5Sopt5hT15KU4z4TqP3dpD/JIwQWt7essDSduvwF5T8wEXw=.kwiu9yNovfcs8Rumz2QSOg";
    $botNo = "6811630";
    $richMenuId = "rm-2205959"; // 先ほど表示されたID

    // 2. トークンを掃除
    $cleanToken = trim($rawToken);

    // 3. 画像生成 (2500x1686)
    $image = imagecreatetruecolor(2500, 1686);
    ob_start();
    imagepng($image);
    $imageData = ob_get_contents();
    ob_end_clean();
    imagedestroy($image);

    $url = "https://www.worksapis.com/v1.0/bots/{$botNo}/richmenus/{$richMenuId}/image";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $imageData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $cleanToken, // 間にスペース1つ
        "Content-Type: image/png",
        "Content-Length: " . strlen($imageData)
    ]);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return "Status: {$status} <br> Response: " . $response;
});
