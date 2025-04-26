<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Member;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_profile()
    {
        $user = User::factory()->create();

        $member = Member::create([
            'user_id' => $user->id,
            'user_name' => 'taro',
            'post_code' => '111-1111',
            'address' => 'テスト県テスト市',
            'building' => 'テスト11号',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');
        $response->assertStatus(200)->assertSee('taro','111-1111','テスト県テスト市','テスト11号');
    }
}
