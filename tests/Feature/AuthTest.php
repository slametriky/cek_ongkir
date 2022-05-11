<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{

    /**
     * @test
     * @group auth
     * @group registration
     */
    public function user_can_register(): void
    {
        $response = $this->json('POST', '/api/register', [
            'name'  =>  $name = 'Test',
            'email'  =>  $email = time().'test@example.com',
            'password'  =>  $password = '123456789',
        ]);       

        $response->assertStatus(200);

        // Receive our token
        $this->assertArrayHasKey('access_token',$response->json());

        User::where('email',$email)->delete();
    }

    /**
     * @test
     * @group auth
     * @group registration
     */
    public function user_can_login(): void
    {
        $email = rand(12345,678910).'test@gmail.com';
        $password = 'password';
        // Creating Users
        $user = User::create([
            'name' => 'test',
            'email' => $email,
            'password' => \Hash::make($password)
        ]);

        $response = $this->json('POST', '/api/login',[
            'email' => $email,
            'password' => $password
        ]);       

        $response->assertStatus(200);

        $this->assertArrayHasKey('data',$response->json());

        // Delete users
        User::where('email',$email)->delete();
    }
        
}
