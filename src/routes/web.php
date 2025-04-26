<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\LikeController;
use App\Http\Requests\ProfileRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('/register',[RegisterController::class,'store']);
Route::post('/login',[LoginController::class,'store']);

Route::prefix('mypage')->group(function () {
    Route::post('profile_img',[MypageController::class,'download']);
    Route::post('profile',[MypageController::class,'set']);
}); 

Route::get('/',[ItemController::class,'index']);
Route::get('/item/:item_id',[ItemController::class,'item']);

Route::middleware('auth')->group(function(){
    Route::get('/purchase/:item_id',[ItemController::class,'purchase']);
    Route::get('/mypage',[MypageController::class,'mypage']);
    Route::get('/sell',[ItemController::class,'sell']);
    Route::post('/item_comment',[ItemController::class,'comment']);
    Route::get('/purchase/address/:item_id',[ItemController::class,'address']);
    Route::get('/mypage/profile',[MypageController::class,'profile']);
    Route::get('/item/:item/like',[LikeController::class,'like']);
    Route::get('/item/:item/unlike',[LikeController::class,'unlike']);
});


Route::post('/order',[ItemController::class,'order']);
Route::patch('/purchase/address/:item_id',[ItemController::class,'edit']);

Route::post('/sell',[ItemController::class,'create']);

Route::get('/search/item',[ItemController::class,'search']);





