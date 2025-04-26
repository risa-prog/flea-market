<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pram=[
            'user_id'=>'1',
            'category_id'=>'1,5',
            'item_name'=>'腕時計',
            'item_image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'price'=>'15000',
            'description'=>'スタイリッシュなデザインのメンズ腕時計',
            'condition'=>'1',
        ];
        DB::table('items')->insert($pram);

        $pram=[
            'user_id'=>'2',
            'item_name'=>'HDD',
            'item_image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'price'=>'5000',
            'description'=>'高速で信頼性の高いハードディスク',
            'condition'=>'2',
            'category_id'=>'2'
        ];
        DB::table('items')->insert($pram);

        $pram=[
            'user_id'=>'2',
            'item_name'=>'玉ねぎ束',
            'item_image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'price'=>'300',
            'description'=>'新鮮な玉ねぎ3束のセット',
            'condition'=>'3',
            'category_id'=>'10'
        ];
        DB::table('items')->insert($pram);

        $pram=[
            'user_id'=>'3',
            'item_name'=>'革靴',
            'item_image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'price'=>'4000',
            'description'=>'クラシックなデザインの革靴',
            'condition'=>'4',
            'category_id'=>'1,5'
        ];
        DB::table('items')->insert($pram);

        $pram=[
            'user_id'=>'1',
            'item_name'=>'ノートPC',
            'item_image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'price'=>'45000',
            'description'=>'高性能なノートパソコン',
            'condition'=>'11',
            'category_id'=>'2'
        ];
        DB::table('items')->insert($pram);

        $pram=[
            'user_id'=>'2',
            'item_name'=>'マイク',
            'item_image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'price'=>'8000',
            'description'=>'高性能のレコーディング用マイク',
            'condition'=>'2',
            'category_id'=>'13'
        ];
        DB::table('items')->insert($pram);

        $pram=[
            'user_id'=>'1',
            'item_name'=>'ショルダーバッグ',
            'item_image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'price'=>'3500',
            'description'=>'おしゃれなショルダーバッグ',
            'condition'=>'3',
            'category_id'=>'1'
        ];
        DB::table('items')->insert($pram);

        $pram=[
            'user_id'=>'3',
            'item_name'=>'タンブラー',
            'item_image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'price'=>'500',
            'description'=>'使いやすいタンブラー',
            'condition'=>'4',
            'category_id'=>'10'
        ];
        DB::table('items')->insert($pram);

        $pram=[
            'user_id'=>'1',
            'item_name'=>'コーヒーミル',
            'item_image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'price'=>'4000',
            'description'=>'手動のコーヒーミル',
            'condition'=>'1',
            'category_id'=>'2'
        ];
        DB::table('items')->insert($pram);

        $pram=[
            'user_id'=>'2',
            'item_name'=>'メイクセット',
            'item_image'=>'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'price'=>'2500',
            'description'=>'便利なメイクアップセット',
            'condition'=>'2',
            'category_id'=>'4,6'
        ];
        DB::table('items')->insert($pram);
    }
}
