<?php

namespace Http\Controllers;

use App\Http\Requests\Users\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    public const API_URI = 'api/auth/user';

    public function testStore(): array
    {
        $userData = [
            "email" => $this->faker->email,
            "user_name" => $this->faker->userName,
            "first_name" => $this->faker->firstName,
            "last_name" => $this->faker->lastName,
            "password" => "test01",
            "email_verified_at" => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            "confirmation_code" => "1234",
            "timezone" => $this->faker->timezone,
            "last_login_at" => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            "last_login_ip" => $this->faker->ipv4
        ];
        $userData['full_name'] = $userData['first_name'] . ' ' . $userData['last_name'];

        $request = RegisterRequest::create(self::API_URI, 'POST', $userData);

        $httpResult = $this->json('POST', self::API_URI, $request->toArray());

        $httpResult->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id'
                ],
                'message',
                'error',
            ]);

        $user = User::query()->where('email', '=', $userData['email'])->first();
        $this->assertInstanceOf(User::class, $user);

        return [$user];
    }
}
