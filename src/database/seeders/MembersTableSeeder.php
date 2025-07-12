<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pram = [
            'user_id' => 1,
            'user_name' => '太郎',
            'post_code' => '111-1111',
            'address' => '東京都新宿区新宿1-1-1',
            'building' => 'マンション1号',
        ];
        DB::table('members')->insert($pram);

        $pram = [
            'user_id'=> 2,
            'user_name' => '花子',
            'post_code' => '222-2222',
            'address' => '東京都新宿区新宿2-2-2',
            'building' => 'マンション2号',
        ];
        DB::table('members')->insert($pram);

    $pram = [
            'user_id'=> 3,
            'user_name' => 'Jiro',
            'post_code' => '333-3333',
            'address' => '東京都新宿区新宿3-3-3',
            'building' => 'マンション3号',
        ];
        DB::table('members')->insert($pram);
    }
}
