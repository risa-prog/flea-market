<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Member;
use App\Models\Order;
use App\Models\Profile;

class MypageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mypage()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $item = Item::create([
                'user_id'=>$user->id,
                'category_id'=>'2',
                'item_name' => 'aaa',
                'item_image' => 'test_item.png',
                'price'=>'1111',
                'description'=>'test_description',
                'condition'=>'2',
        ]);

        $item2 = Item::create([
                'user_id'=>$user2->id,
                'category_id'=>'1',
                'item_name' => 'bbb',
                'item_image' => 'test_item2.png',
                'price'=>'1111',
                'description'=>'test_description2',
                'condition'=>'1',
        ]);

        $member = Member::create([
            'user_id'=>'1',
            'user_name'=>'太郎',
            'post_code'=>'111-1111',
            'address'=>'テスト県テスト市',
            'building'=>'テスト11号',
        ]);

        $order=Order::create([
            'user_id'=>'1',
            'item_id'=>'2',
            'payment_method'=>'1',
            'post_code'=>'111-1111',
            'address'=>'テスト県テスト市',
            'building'=>'テスト11号',
        ]);

        $profile = Profile::create([
            'user_id' => $user->id,
            'profile_image' => 'test.png',
        ]);

        // プロフィール画像、ユーザー名が表示されてるか
        $response =  $this->actingAs($user)->get('/mypage');
        $response->assertStatus(200)->assertSee(asset('storage/test.png'),'太郎');

        // 出品した商品が表示されるか
        $response = $this->get('/mypage?tab=sell')->assertSee($item->item_name);

        // 購入した商品が表示されるか
        $response = $this->get('/mypage?tab=buy')->assertSee('bbb');

    }
}
