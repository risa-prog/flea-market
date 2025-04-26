<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Auth;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_logout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        $response = $this->post('/logout');
        $response->assertStatus(302);

        $response = $this->get('/login');
        $response->assertStatus(200);
        $this->assertGuest();

        
 
        
 
        // $this->assertAuthenticated();
 
        
 
        
    }
}
      
