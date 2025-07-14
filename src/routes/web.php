<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TradingChatController;
use App\Http\Controllers\TransactionCommentController;
use App\Http\Controllers\TransactionReviewController;


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

Route::get(
    '/login',
    [AuthController::class, 'showLoginForm']
)->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get(
    '/register',
    [AuthController::class, 'showRegisterForm']
);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/:item_id', [ItemController::class, 'item']);

Route::middleware(['auth'])->group(function(){
    Route::get('/purchase/:item_id',[ItemController::class,'purchase']);
    Route::get('/mypage',[MypageController::class,'mypage']);
    Route::get('/sell',[ItemController::class,'sell']);
    Route::post('/item_comment',[ItemController::class,'comment']);
    Route::get('/purchase/address/:item_id',[ItemController::class,'address']);
    Route::get('/mypage/profile',[MypageController::class,'profile']);
    Route::get('/item/:item/like',[LikeController::class,'like']);
    Route::get('/item/:item/unlike',[LikeController::class,'unlike']);
    Route::prefix('mypage')->group(function () {
        Route::post('profile_img', [MypageController::class, 'download']);
        Route::post('profile', [MypageController::class, 'set']);
    });
    Route::post('/order', [ItemController::class, 'order']);
    Route::patch('/purchase/address/:item_id', [ItemController::class, 'edit']);
    Route::post('/sell', [ItemController::class, 'create']);

    // 入会テスト追加分
    Route::get('/trading_chat', [TradingChatController::class, 'index'])->name('trading.chat');

    Route::post('/trading_chat/comment/create',[TransactionCommentController::class,'create']);
    Route::post('/trading_chat/comment/edit', [TransactionCommentController::class, 'edit'])->name('comment.edit');
    Route::post('/item/transaction/complete',[TradingChatController::class,'complete']);
    Route::post('/transaction/review',[TransactionReviewController::class,'create']);
});

Route::get('/search/item',[ItemController::class,'search']);









