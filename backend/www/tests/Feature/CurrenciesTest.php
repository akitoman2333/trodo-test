<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CurrenciesTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function currencies(): void
    {
        $token = $this->getToken();
        $url = '/api/v1/сurrency/EUR/USD';
        $this->get($url, [
            'authorization' => "bearer $token"
        ])->assertStatus(200);

    }

    private function getToken()
    {
        $password = $this->faker->password(8);
        $email = $this->faker->email();
        User::create([
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        return auth('api')->attempt([
            'email' => $email,
            'password' => $password
        ]);
    }
}
