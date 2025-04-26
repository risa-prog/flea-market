<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\UploadedFile;

class SellTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sell()
    {
        $user = User::factory()->create();
        $response =  $this->actingAs($user)->get('/sell');
        $response->assertStatus(200);

        $file = new UploadedFile(storage_path("app/public/1735615757575.jpg"), "1735615757575.jpg");
    
        $itemData = [
            'category_id'=>'1',
            'item_name' => 'テストitem',
            'item_image' => $file,
            'price'=>'1111',
            'description'=>'test_description',
            'condition'=>'2',
        ];
    
        $response = $this->post('/sell', $itemData);
        $response->assertStatus(200);

         $this->assertDatabaseHas(Item::class, [
             'user_id'=>'1',
             'category_id'=>'1',
             'item_name' => 'テストitem',
             'item_image' => 'test_item.png',
             'price'=>'1111',
             'description'=>'test_description',
            'condition'=>'2',
         ]);
    }
}
