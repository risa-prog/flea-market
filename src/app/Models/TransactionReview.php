<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionReview extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id','reviewer_id','reviewee_id','rating'];

    public function transaction() {
        return $this->belongsTo('App\Models\Transaction');
    }
}
