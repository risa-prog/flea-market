<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'buyer_id', 'seller_id',
        'status'
    ];

    public function item() {
        return $this->belongsTo('App\Models\Item');
    }

    public function transactionComments() {
        return $this->hasMany('App\Models\TransactionComment');
    }
}
