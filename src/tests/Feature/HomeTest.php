<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        
        $item = Item::create([
                'user_id'=>$user->id,
                'category_id'=>'2',
                'item_name' => 'テストitem',
                'item_image' => 'test_item.png',
                'price'=>'1111',
                'description'=>'test_description',
                'condition'=>'2',
        ]);
        $this->assertTrue($item->exists);

        $item2 = Item::create([
                'user_id'=>$user2->id,
                'category_id'=>'1',
                'item_name' => 'テストitem2',
                'item_image' => 'test_item2.png',
                'price'=>'1111',
                'description'=>'test_description2',
                'condition'=>'1',
        ]);
        $this->assertTrue($item2->exists);

        $order=Order::create([
            'user_id'=>'1',
            'item_id'=>'1',
            'payment_method'=>'1',
            'post_code'=>'111-1111',
            'address'=>'テスト県テスト市',
            'building'=>'テスト11号',
        ]);
        $this->assertTrue($order->exists);

        $response = $this->get('/');
        $response->assertStatus(200);

         $response = $this->get('/');
         $response->assertStatus(200)->assertViewIs('index')->assertSee('テストitem','テストitem2','Sold');

         $response =  $this->actingAs($user2)->get('/');
        $response->assertStatus(200)->assertSee('テストitem')->assertDontSee('テストitem2');
    }
}


