<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('api_login');
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('api_logout');

Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('api_register');
Route::post('/image-upload', [\App\Http\Controllers\Api\RegisterController::class, 'UploadImage'])->name('image_upload');
Route::get('/cek-nik', [\App\Http\Controllers\Api\RegisterController::class, 'checkNIK'])->name('api_check_nik');


Route::group(['prefix' => 'dashboard', 'middleware' => ['jwt.verify']], function () {
    Route::get('/profile', [\App\Http\Controllers\Api\ProfileController::class, 'index'])->name('api_profile');
    Route::post('/profile', [\App\Http\Controllers\Api\ProfileController::class, 'store'])->name('api_profile_update');

    Route::get('/faq', [\App\Http\Controllers\Api\FAQController::class, 'index'])->name('api_faq_all');
});

//Route::middleware('auth:api')->get('/profile', function (Request $request) {
//    return $request->user();
//});
