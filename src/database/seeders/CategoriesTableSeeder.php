<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pram=[
            'content'=>'ファッション'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'家電'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'インテリア'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'レディース'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'メンズ'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'コスメ'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'本'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'ゲーム'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'スポーツ'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'キッチン'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'ハンドメイド'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'アクセサリー'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'おもちゃ'
        ];
        DB::table('categories')->insert($pram);

        $pram=[
            'content'=>'ベビー・キッズ'
        ];
        DB::table('categories')->insert($pram);
    }
}
