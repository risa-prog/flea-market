<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionComment;
use App\Models\TransactionReview;
use Illuminate\Support\Facades\Mail;

class TradingChatController extends Controller
{
    public function index(Request $request) {
        $item = Item::with('transaction.transactionComments')->find($request->item_id);
        $user = Auth::user();

        // ユーザーが取引のある商品を全て取得
        $transactions = Transaction::where(function ($query) use ($user){
            $query->where('seller_id', $user->id)
                ->orWhere('buyer_id', $user->id);
        })
        ->where('status', 1)
        ->get();

        // ユーザーが取引のある商品のうち、新着メッセージが来た順にソート
        $sortedTransactions = $transactions->sortByDesc(
            function ($transaction) use ($user) {
                // receiver_id が自分と一致するコメントの中で、最新の created_at を取得
                $matchedComment = $transaction->transactionComments
                    ->where('receiver_id', $user->id)
                    ->sortByDesc('created_at')
                    ->first();

                // 該当するコメントがなければ null → 後ろに並ぶ
                return optional($matchedComment)->created_at;
            });

        $transaction = Transaction::where('item_id', $item->id)->first();

        // 取引相手のデータを取得
        if($user->id === $transaction->buyer_id) {
            $client_id = $transaction->seller_id;
            $client = User::with('member')->find($client_id);
        }elseif($user->id === $transaction->seller_id) {
            $client_id = $transaction->buyer_id;
            $client = User::with('member')->find($client_id);
        }
        
        $my_transaction_comments = TransactionComment::where('sender_id',$user->id)->where('transaction_id',$transaction->id)->get();

        // session([
        //     'form_data' => [
        //         'content' => $request->input('content')
        //     ]
        // ]);

        // 既読処理
        if ($transaction->transactionComments->isNotEmpty()) {
            foreach ($transaction->transactionComments as $transaction_comment) {
                if ($transaction_comment->is_read === 1 && $user->id === $transaction_comment->receiver_id) {
                    $transaction_comment->update(['is_read' => 2]);
                }
            }
        }

        // $hasReviewed = TransactionReview::with(['transaction' => function($query) {
        //     $query->where('status', 2);
        // }])
        // ->where('transaction_id', $transaction->id)
        // ->where('reviewer_id', $user->id)
        // ->exists();
        // dd($hasReviewed);

        $hasReviewed = TransactionReview::where('transaction_id', $transaction->id)
            ->where('reviewer_id', Auth::id())
            ->exists();

        return view('trading_chat',compact('item', 'sortedTransactions','client', 'my_transaction_comments','hasReviewed'));
    }

    public function complete(Request $request) {
        $transaction_id = $request->transaction_id;
        $transaction = Transaction::find($transaction_id);
        $transaction->update(['status' => 2]);

        $seller = User::find($transaction->seller_id);

        $data = [];

        Mail::send('transaction_mail', $data, function ($message) use ($seller){
            $message->to($seller->email, 'Complete')->subject('The transaction is complete');
        });

        return redirect()->route('trading.chat',['item_id' => $request->item_id]);
    }
}
