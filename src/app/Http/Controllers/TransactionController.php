<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function create(Request $request) {
        $item = Item::find($request->item_id);
        $buyer_id = Auth::id();
        $seller_id = $item->user_id;

        Transaction::create([
            'item_id' => $item->id,
            'buyer_id' => $buyer_id,
            'seller_id' => $seller_id,
            'status' => 1,
        ]);

        return redirect()->back()->with('success', '取引を開始しました');
    }
}
