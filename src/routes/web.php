<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TradingChatController;
use App\Http\Controllers\TransactionCommentController;
use App\Http\Controllers\TransactionReviewController;
use App\Http\Controllers\TransactionController;


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
Route::get('/item', [ItemController::class, 'item'])->name('item');

Route::middleware(['auth'])->group(function(){
    Route::get('/purchase',[ItemController::class,'purchase'])->name('purchase');
    
    Route::get('/sell',[ItemController::class,'sell']);
    Route::post('/item_comment',[ItemController::class,'comment']);
    Route::get('/purchase/address/:item_id',[ItemController::class,'address']);
    Route::get('/mypage/profile',[MypageController::class,'profile']);
    Route::get('/item/:item/like',[LikeController::class,'like']);
    Route::get('/item/:item/unlike',[LikeController::class,'unlike']);
    Route::post('/mypage/profile', [MypageController::class, 'set']);

    Route::post('/order', [ItemController::class, 'order'])->name('order');
    Route::get('/purchase/address/edit',[ItemController::class,'showAddressForm'])->name('address.form');
    Route::patch('/purchase/address/edit', [ItemController::class, 'edit'])->name('edit');
    Route::post('/sell', [ItemController::class, 'create']);

    Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');

    Route::post('/purchase/address',[ItemController::class,'address'])->name('address');

    // 入会テスト追加分

    // 取引チャット画面へ
    Route::get('/trading_chat', [TradingChatController::class, 'index'])->name('trading.chat');

    // コメント機能
    Route::post('/trading_chat/comment/create',[TransactionCommentController::class,'create'])->name('comment.create');
    Route::post('/trading_chat/comment/edit', [TransactionCommentController::class, 'edit'])->name('comment.edit');

    // 取引完了
    Route::post('/item/transaction/complete',[TradingChatController::class,'complete'])->name('transaction.complete');
    // 評価
    Route::post('/transaction/review',[TransactionReviewController::class,'create'])->name('transaction.review');

    // ホームにて「購入」ボタン押下したとき
    Route::post('/purchase/transaction',[TransactionController::class,'create'])->name('purchase.transaction');
});

Route::get('/search/item',[ItemController::class,'search']);









