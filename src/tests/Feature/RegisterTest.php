<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;


class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register(){
        $response = $this->get('/register');
        $response->assertStatus(200);

        $password = bcrypt('Test1234');
        $user_data = [
           'name' => 'test太郎',
           'email' => 'test@gmail.com',
           'email_verified_at' => now(),
           'password' => $password,
           'password_confirmation' => $password,
           'remember_token' => Str::random(10),
       ];

       $response = $this->post('/register', $user_data);
       $response->assertSessionHasNoErrors(); 

        $response->assertRedirect('/login');
    }

    /**
     * * @test
    * @dataProvider dataproviderValidation
    */
    public function validationCheck(array $params, array $messages, bool $expect): void
    {
        $request = new RegisterRequest();
        $rules = $request->rules();
        $validator = Validator::make($params, $rules);
        $validator = $validator->setCustomMessages($request->messages());
        // $result = $validator->passes();

        // $this->assertEquals($expect, $result);
        $res = $this->assertSame($messages, $validator->errors()->messages());

    }

    public function dataproviderValidation(){
        return [
            'name null' => [
                [
                    'name' => null,
                    'email'=>'test@gmail.com',
                    'password'=>'test8888',
                    'password_confirmation' => 'test8888'
                ],
                [
                    'name' => [
                        'お名前を入力してください'
                    ],
                ],
                true
            ],
            'email null' => [
                [
                    'name' => 'テスト太郎',
                    'email'=> null,
                    'password'=>'test8888',
                    'password_confirmation' => 'test8888'
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
                    'name' => 'テスト太郎',
                    'email'=>'test@gmail.com',
                    'password'=> null,
                    'password_confirmation' => 'test8888'
                ],
                [
                    'password' => [
                        'パスワードを入力してください',
                    ],
                    'password_confirmation' => [
                        'パスワードと一致しません'
                    ]
                ],
                true
            ],
            'password min' => [
                [
                    'name' => 'テスト太郎',
                    'email'=>'test@gmail.com',
                    'password' => 'test888',
                    'password_confirmation' => 'test8888'
                ],
                [
                    'password' => [
                        'パスワードは8文字以上で入力してください'
                    ],
                    'password_confirmation' => [
                        'パスワードと一致しません'
                    ]
                ],
                true
            ],
        ];
    }
}
