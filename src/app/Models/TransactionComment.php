<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionComment extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id','sender_id','receiver_id','is_read','content','image',];

    public function transaction() {
        return $this->belongsTo('App\Models\Transaction');
    }
}
