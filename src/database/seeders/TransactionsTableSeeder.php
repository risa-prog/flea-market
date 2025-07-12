<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pram = [
            'item_id' => 1,
            'buyer_id' => 2,
            'seller_id' => 1,
            'status' => 1,
            
        ];
        DB::table('transactions')->insert($pram);

        $pram = [
            'item_id' => 2,
            'buyer_id' => 2,
            'seller_id' => 1,
            'status' => 1,
        ];
        DB::table('transactions')->insert($pram);

        $pram = [
            'item_id' => 3,
            'buyer_id' => 3,
            'seller_id' => 1,
            'status' => 1,
        ];
        DB::table('transactions')->insert($pram);

        $pram = [
            'item_id' => 6,
            'buyer_id' => 1,
            'seller_id' => 2,
            'status' => 1,
        ];
        DB::table('transactions')->insert($pram);

        $pram = [
            'item_id' => 7,
            'buyer_id' => 1,
            'seller_id' => 2,
            'status' => 1,

        ];
        DB::table('transactions')->insert($pram);

        $pram = [
            'item_id' => 8,
            'buyer_id' => 3,
            'seller_id' => 2,
            'status' => 1,

        ];
        DB::table('transactions')->insert($pram);
    }
}
