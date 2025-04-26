<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_like()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $category = Category::create([
            'content'=>'category1'
        ]);
        
        $item = Item::create([
                'user_id'=>'1',
                'category_id'=>'1',
                'item_name' => 'テストitem',
                'item_image' => 'test_item.png',
                'brand_name'=>'brandテスト',
                'price'=>'555',
                'description'=>'test_description',
                'condition'=>'1',
        ]);

        $like = Like::create([
            'user_id' => '2',
            'item_id' => '1'
        ]);

        $response = $this->get('/item/:item_id?id=1');
        $response->assertStatus(200);

        // いいねしたとき
        $response =  $this->actingAs($user3)->get('/item/:item/like?item_id=1');
        $response->assertStatus(302);
        $this->get('/item/:item_id?id=1')->assertSee($like->count());
        $this->assertEquals($like->count(),'2');

        // いいねを再度押したとき
        $this->get('/item/:item/unlike?item_id=1');
        $response->assertStatus(302);
        $this->get('/item/:item_id?id=1')->assertSee($like->count());$this->assertEquals($like->count(),'1');
    }
}
