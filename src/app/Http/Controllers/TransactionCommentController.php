<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\TransactionComment;
use App\Http\Requests\TransactionCommentRequest;
use App\Http\Requests\TransactionCommentUpdateRequest;
use App\Models\Transaction;

class TransactionCommentController extends Controller
{
    public function create(TransactionCommentRequest $request) {
        $user_id = Auth::id();
        $transaction = Transaction::find($request->transaction_id);

        if ($user_id === $transaction->buyer_id) {
            $receiver_id = $transaction->seller_id;
        } elseif ($user_id === $transaction->seller_id) {
            $receiver_id = $transaction->buyer_id;
        }

        if($request->image !== null){
            $image_name = $request->image->getClientOriginalName();
            // 画像の保存
            $request->image->storeAs('', $image_name, 'public');
        }else {
            $image_name = null;
        }
        
        TransactionComment::create([
            'transaction_id' => $transaction->id,
            'sender_id' => $user_id,
            'receiver_id' => $receiver_id,
            'content' => $request->content,
            'image' => $image_name,
            'is_read' => 1,
        ]);
        
        return redirect()->route('trading.chat', ['item_id' => $request->item_id]);
    }

    public function edit(TransactionCommentUpdateRequest $request) {
        $action = $request->input('action');
        $id = $request->id;

        if ($action === 'delete') {
            TransactionComment::find($id)->delete();
        } elseif($action === 'update') {
            $content2 = $request->input('content2');
            // キーに関係なく、配列の最初の値だけを取り出す
            $content = reset($content2);
            $transaction_comment = TransactionComment::find($id);
            $transaction_comment->update(['content' => $content]);

            if($transaction_comment->is_read === 2) {
                $transaction_comment->update(['is_read' => 1]);
            }
        }

        return redirect()->route('trading.chat', ['item_id' => $request->item_id]);
    }
}
