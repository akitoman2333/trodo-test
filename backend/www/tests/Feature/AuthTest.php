<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use WithFaker;
    use DatabaseTransactions;

    public function test_auth()
    {
        $password = $this->faker->password(8);
        $email = $this->faker->email();
        User::create([
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $this->post('/api/v1/auth/login', [
            'email' => $email,
            'password' => $password
        ])->assertStatus(200);
    }

    public function test_register_user()
    {
        $data = [
            'name' => $this->faker->name(),
            'email' => 'my-custom@mail.com',
            'password' => bcrypt($this->faker->password(8))
        ];

        $this->post('/api/v1/auth/register', $data)->assertStatus(201);
    }

    public function test_get_auth_user()
    {
        $password = $this->faker->password(8);
        $email = $this->faker->email();
        User::create([
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $token = auth('api')->attempt([
            'email' => $email,
            'password' => $password
        ]);

        $this->get('/api/v1/auth/user', [
            'authorization' => "bearer $token"
        ])->assertStatus(200);
    }

    public function test_logout()
    {
        $password = $this->faker->password(8);
        $email = $this->faker->email();
        User::create([
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $token = auth('api')->attempt([
            'email' => $email,
            'password' => $password
        ]);

        $this->post('/api/v1/auth/logout', [], [
            'authorization' => "bearer $token"
        ])->assertStatus(200);
    }

    public function test_refresh()
    {
        $password = $this->faker->password(8);
        $email = $this->faker->email();
        User::create([
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $token = auth('api')->attempt([
            'email' => $email,
            'password' => $password
        ]);

        $this->post('/api/v1/auth/refresh', [], [
            'authorization' => "bearer $token"
        ])->assertStatus(200);
    }
}
