<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionReview;

class TransactionReviewController extends Controller
{
    public function index(Request $request) {
        $transaction_id = $request->transaction_id;
        return view('transaction_review',compact('transaction_id'));
    }

    public function create(Request $request) {
        $transaction = Transaction::find($request->transaction_id);
        $reviewer_id = Auth::id();

        if(Auth::id() === $transaction->buyer_id) {
            $reviewee_id = $transaction->seller_id;
        }elseif(Auth::id() === $transaction->seller_id) {
            $reviewee_id = $transaction->buyer_id;
        }

        TransactionReview::create([
            'transaction_id' => $transaction->id,
            'reviewer_id' => $reviewer_id,
            'reviewee_id' => $reviewee_id,
            'rating' => $request->rating,
        ]);

        return redirect('/');
    }
} 
