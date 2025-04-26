<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_search()
    {
        $user = User::factory()->create();
        
        $item = Item::create([
                'user_id'=>$user->id,
                'category_id'=>'1',
                'item_name' => 'aaa',
                'item_image' => 'test.png',
                'price'=>'1111',
                'description'=>'test_description',
                'condition'=>'1',
        ]);

        $item2 = Item::create([
                'user_id'=>$user->id,
                'category_id'=>'2',
                'item_name' => 'bbb',
                'item_image' => 'test2.png',
                'price'=>'111',
                'description'=>'test_description2',
                'condition'=>'1',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200)->assertSee('aaa','bbb');

        $keyword = [
            'keyword' => 'a'
        ];
        $response = $this->get('/search/item',$keyword);
        
        $response->assertStatus(200)->assertSee('aaa')->dd();

    }
}
