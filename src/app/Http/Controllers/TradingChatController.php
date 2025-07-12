<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionComment;
use Illuminate\Support\Facades\Mail;

class TradingChatController extends Controller
{
    public function index(Request $request) {
        $item = Item::find($request->item_id);
        $user = Auth::user();
        $transactions = Transaction::where(function ($query) {
            $query
            ->where('buyer_id', Auth::id())
            ->orWhere('seller_id', Auth::id());
        })->where('status', 1)->get();
        
        if($user->id === $item->transaction->buyer_id) {
            $client_id = $item->transaction->seller_id;
            $client = User::find($client_id);
        }elseif($user->id === $item->transaction->seller_id) {
            $client_id = $item->transaction->buyer_id;
            $client = User::find($client_id);
        }
        
        $my_transaction_comments = TransactionComment::where('sender_id',$user->id)->where('transaction_id',$item->transaction->id)->get();

        // dd($item->transaction->transactionComments);
        if($item->transaction->transactionComments->isNotEmpty()) {
            foreach($item->transaction->transactionComments as $transaction_comment) {
                if($transaction_comment->is_read === 1 && Auth::id() === $transaction_comment->receiver_id) {
                    $transaction_comment->update(['is_read' => 2]);
                }
            }
        }
        
        return view('trading_chat',compact('item','transactions','client', 'my_transaction_comments'));
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

        return redirect()->route('transaction.review', ['transaction_id' => $transaction_id]);
    }
}
