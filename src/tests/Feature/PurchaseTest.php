<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Member;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_purchase()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $item = Item::create([
                'user_id'=>$user2->id,
                'category_id'=>'1',
                'item_name' => 'テストitem',
                'item_image' => 'test.png',
                'brand_name'=>'brandテスト',
                'price'=>'1111',
                'description'=>'test_description',
                'condition'=>'1',
        ]);

        $member = Member::create([
            'user_id'=>$user->id,
            'user_name'=>'太郎',
            'post_code'=>'111-1111',
            'address'=>'テスト県テスト市',
            'building'=>'テスト11号',
        ]);

        // 購入画面にて購入する
        $response =  $this->actingAs($user)->get('/purchase/:item_id?id=1');
        $response->assertStatus(200);

        $response = $this->post('/order', [
            'item_id' => '1',
            'payment_method' => '1',
            'post_code' => '222-2222',
            'address' => 'テスト県テスト市',
            'building' => 'テスト1号',
        ]);
        $response->assertStatus(302);

        $this->assertDatabaseHas('orders', [
             'user_id'=>$user->id,
             'item_id' => '1',
             'payment_method' => '1',
            'post_code' => '222-2222',
            'address' => 'テスト県テスト市',
            'building' => 'テスト1号'
         ]);

        //  商品一覧画面にて、購入した商品に「Sold」の表示
        $response = $this->get('/');
        $response->assertStatus(200)->assertViewIs('index')->assertSee('テストitem','Sold');

        // 「プロフィール/購入した商品一覧」に追加されてる
        $response = $this->actingAs($user)->get('/mypage?tab=buy');
        $response->assertStatus(200)->assertSee('テストitem');
    }
 }

