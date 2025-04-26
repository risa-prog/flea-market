<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Member;
use App\Models\Order;

class AddressTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_address()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $item = Item::create([
                'user_id'=>$user->id,
                'category_id'=>'1',
                'item_name' => 'abc',
                'item_image' => 'test_bag.png',
                'price'=>'1111',
                'description'=>'test_description',
                'condition'=>'1',
        ]);

        $member = Member::create([
            'user_id' => $user2->id,
            'user_name' => 'taro',
            'post_code' => '111-1111',
            'address' => 'テスト県テスト市',
            'building' => 'テスト11号',
        ]);

        // ログインして購入画面へ
        $response = $this->actingAs($user2)->get('/purchase/:item_id?id=1');
        $response->assertStatus(200);

        // 配送先変更画面へ
        $response =  $this->actingAs($user2)->get('/purchase/address/:item_id?id=1');
        $response->assertStatus(200);

        // 配送先の変更をする
        $response = $this->patch('/purchase/address/:item_id', [
            'item_id' => '1',
            'post_code' => '222-2222',
            'address' => 'テスト県B市',
            'building' => '2号',
          ]);
          // 配送先変更が反映されているか確認
          $response->assertStatus(200)->assertSee('222-2222','テスト県B市','2号');;

        // 購入画面にて購入する
        $response = $this->post('/order',[
             'item_id' => '1',
             'payment_method' => '2',
             'post_code' => '222-2222',
             'address' => 'テスト県B市',
             'building' => '2号',
           ]);
        $response->assertStatus(302);

        $this->assertDatabaseHas('orders', [
            'user_id'=>$user2->id,
            'item_id'=>'1',
            'payment_method' => '2',
            'post_code' => '222-2222',
            'address' => 'テスト県B市',
            'building' => '2号',
        ]);

    }

    
}
