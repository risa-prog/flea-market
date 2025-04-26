<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Validator;
use Auth;


class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_comment()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $category = Category::create([
            'content'=>'category1'
        ]);

        $item = Item::create([
                'user_id'=>'1',
                'category_id'=>'1',
                'item_name' => 'テストitem',
                'item_image' => 'test_item.png',
                'brand_name'=>'brandテスト',
                'price'=>'1111',
                'description'=>'test_description',
                'condition'=>'1',
        ]);

        $response = $this->get('/item/:item_id?id=1');
        $response->assertStatus(200);

        // ログインしていないとき
        $this->assertFalse(Auth::check());
        $response = $this->post('/item_comment',[
            'item_id'=>'1',
            'content'=>'テストcomment'
         ]);
        $response->assertRedirect('/login');

        // ログインしているとき
        $response = $this->actingAs($user)->post('/item_comment',[
            'user_id'=>$user2->id,
            'item_id'=>'1',
            'content'=>'テストcomment'
         ]);
        $response->assertStatus(200);
    }

    /**
     * * @test
    * @dataProvider dataproviderValidation
    */
    public function validationCheck(array $params, array $messages, bool $expect): void
    {
        $request = new CommentRequest();
        $rules = $request->rules();
        $validator = Validator::make($params, $rules);
        $validator = $validator->setCustomMessages($request->messages());
        $res = $this->assertSame($messages, $validator->errors()->messages());

    }

    public function dataproviderValidation(){
        return [
            'comment null' => [
                [
                    'content' => null,
                ],
                [
                    'content' => [
                        'コメントを入力してください'
                    ],
                ],
                true
            ],
            'comment max' => [
                [
                    'content' => str_repeat('あ', 256)
                ],
                [
                    'content' => [
                        'コメントは255文字以内で入力してください'
                    ],
                ],
                true
            ]
        ];
    }
}
