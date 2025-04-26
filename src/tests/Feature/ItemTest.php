<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Member;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Profile;

class ItemTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_item()
    {
        $user = User::factory()->create();

        $category = Category::create([
            'content'=>'category1'
        ]);
        $category2 = Category::create([
            'content'=>'category2'
        ]);

        $item = Item::create([
                'user_id'=>'1',
                'category_id'=>'1,2',
                'item_name' => 'テストitem',
                'item_image' => 'test_item.png',
                'brand_name'=>'brandテスト',
                'price'=>'1111',
                'description'=>'test_description',
                'condition'=>'1',
        ]);
        $this->assertTrue($item->exists);

        $member = Member::create([
            'user_id'=>'1',
            'user_name'=>'太郎',
            'post_code'=>'111-1111',
            'address'=>'テスト県テスト市',
            'building'=>'テスト11号',
        ]);

        $comment=Comment::create([
            'user_id'=>'1',
            'item_id'=>'1',
            'content'=>'テストcomment',
        ]);
        $this->assertTrue($comment->exists);

        $like = Like::create([
            'user_id' => '1',
            'item_id' => '1'
        ]);
        $this->assertTrue($like->exists);

        $profile = Profile::create([
            'user_id' => $user->id,
            'profile_image' => 'test.png',
        ]);


        $response = $this->get('/item/:item_id?id=1');
        $response->assertStatus(200)->assertViewIs('item')->assertSee(asset('storage/test_item.png'))->assertSee('テストitem','brandテスト','1111',$like->count(),$comment->count(),'test_description','category1','category2','良好','太郎','テストcomment');
    }
}
