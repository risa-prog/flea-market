<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;
use Auth;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // 正しい情報が入力されたとき
    public function test_login()
    {
        $user = User::factory()->create([
            'password' =>bcrypt('laraveltest123')
        ]);

        $this->assertFalse(Auth::check());

        $response =$this->post('/login',[
            'email' => $user->email,
            'password' => 'laraveltest123'
        ]);

        $this->assertTrue(Auth::check());

        
    }

    /**
     * * @test
    * @dataProvider dataproviderValidation
    */
    // 入力情報が間違っているとき
    public function validationCheck(array $params, array $messages, bool $expect): void
    {
        $request = new LoginRequest();
        $rules = $request->rules();
        $validator = Validator::make($params, $rules);
        $validator = $validator->setCustomMessages($request->messages());
        $res = $this->assertSame($messages, $validator->errors()->messages());

    }

    public function dataproviderValidation(){
        return [
            'email null' => [
                [
                    'email' => null,
                    'password'=>'test8888'
                ],
                [
                    'email' => [
                        'メールアドレスを入力してください'
                    ],
                ],
                true
            ],
            'password null' => [
                [
                    'email' => 'test@gmail.com',
                    'password'=> null,
                ],
                [
                    'password' => [
                        'パスワードを入力してください'
                    ],
                ],
                true
            ]
        ];
    }
}
