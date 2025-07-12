<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionComment extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id','user_id','content','image',];
}
