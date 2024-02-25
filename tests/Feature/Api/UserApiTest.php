<?php

namespace Api;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->seed(UserSeeder::class);
    }

    public function test_users_route(): void
    {
        $user = User::where('email','lamarijan@gmail.com')->first();
        $this->actingAs($user,'web');
        $response = $this->get('/api/users');
        $response->assertStatus(200);
    }
}