<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pram=[
            'name' => '山田太郎',
            'email' =>'taro@gmail.com',
            'password' => Hash::make('taro9999'),
        ];
        DB::table('users')->insert($pram);

        $pram=[
            'name' => '山田花子',
            'email' =>'hanakoymd@gmail.com',
            'password' => Hash::make('hanako875'),
        ];
        DB::table('users')->insert($pram);

        $pram=[
            'name' => '山田次郎',
            'email' =>'yamadaj@gmail.com',
            'password' => Hash::make('jiro8888'),
        ];
        DB::table('users')->insert($pram);

    }
}
