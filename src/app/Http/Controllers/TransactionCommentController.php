<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionComment;
use App\Http\Requests\TransactionCommentRequest;
use App\Http\Requests\TransactionCommentUpdateRequest;

class TransactionCommentController extends Controller
{
    public function create(TransactionCommentRequest $request) {
        $user = Auth::user();
        $transaction_comment = $request->only(['content', 'transaction_id']);
        $transaction_comment = array_merge($transaction_comment, array('user_id' => $user->id));

        if($request->image !== null){
            $image_name = $request->image->getClientOriginalName();
            // 画像の保存
            $request->image->storeAs('', $image_name, 'public');
            $transaction_comment['image'] = $image_name;
        }
        
        TransactionComment::create($transaction_comment);
        
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
        }

        return redirect()->route('trading.chat', ['item_id' => $request->item_id]);
    }
}
