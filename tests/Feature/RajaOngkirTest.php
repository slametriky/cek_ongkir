<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RajaOngkirTest extends TestCase
{
    protected function authenticate()
    {
        $user = User::create([
            'name' => 'test',
            'email' => rand(12345,678910).'test@gmail.com',
            'password' => \Hash::make('secret9874'),
        ]);

        if (!auth()->attempt(['email'=>$user->email, 'password'=>'secret9874'])) {
            return response(['message' => 'Login credentials are invaild']);
        }

        return $accessToken = auth()->user()->createToken('auth_token')->plainTextToken;
    }

   /**
     * @test
     */
    public function user_login_can_access_cities()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/search/cities?id=1');                

        $response->assertStatus(200);
        $this->assertArrayHasKey('data',$response->json());
    }

    /**
     * @test
     */
    public function user_login_can_access_provinces()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/search/provinces?id=1');                

        $response->assertStatus(200);
        $this->assertArrayHasKey('data',$response->json());
    }

     /**
     * @test
     */
    public function guest_user_cannot_access_data()
    {        
        $response = $this->json('GET','api/search/provinces?id=1');                

        $response->assertStatus(401);
    }

}
