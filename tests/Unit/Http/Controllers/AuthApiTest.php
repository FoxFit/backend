<?php

namespace Http\Controllers;

use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    /**
     * @var string
     */
    public const API_REGISTER = '/api/auth/register';
    public const API_LOGIN = '/api/auth/login';
    public const API_PROFILE = '/api/auth/profile';
    public const API_CHECK = '/api/auth/check';
    public const API_LOGOUT = '/api/auth/logout';

    public function testRegisterSuccess(): array
    {
        $uri = self::API_REGISTER;

        $userData = [
            'email'       => $this->faker->email,
            'password'    => '123456',
            'user_name'   => $this->faker->userName,
            'first_name'  => $this->faker->firstName,
            'last_name'   => $this->faker->lastName,
            'agree'       => 1,
        ];

        $userData['full_name'] = $userData['first_name'] . ' ' . $userData['last_name'];

        $request = RegisterRequest::create($uri, 'POST', $userData);

        $httpResult = $this->json('POST', $uri, $request->toArray());
        $httpResult->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'user_name',
                    'full_name',
                    'first_name',
                    'last_name',
                    'email',
                    'updated_at',
                    'created_at',
                ],
                'message',
                'error',
            ]);

        $user = User::query()->where('email', '=', $userData['email'])->first();
        $this->assertInstanceOf(User::class, $user);

        return [$user];
    }

    /**
     * @depends testRegisterSuccess
     * @param array $params
     * @return array
     */
    public function testLoginSuccess(array $params): array
    {
        [$user] = $params;

        $uri = self::API_LOGIN;

        $userData = [
            'user_name' => $user->user_name,
            'password'  => '123456',
        ];

        $request = LoginRequest::create($uri, 'POST', $userData);

        $httpResult = $this->json('POST', $uri, $request->toArray());
        $httpResult->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_at',
                ],
                'message',
                'error',
            ]);

        return [$user];
    }

    /**
     * @depends testLoginSuccess
     * @param array $params
     * @return array
     */
    public function testLoginFail(array $params): array
    {
        [$user] = $params;

        $uri = self::API_LOGIN;

        $userData = [
            'user_name' => $user->user_name,
            'password'  => '333333',
        ];

        $request = LoginRequest::create($uri, 'POST', $userData);

        $httpResult = $this->json('POST', $uri, $request->toArray());
        $httpResult->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertContent(json_encode([
                'status'  => 'failed',
                'data'    => [],
                'message' => null,
                'error'   => __('auth.password.incorrect'),
            ]));

        return [$user];
    }

    /**
     * @depends testLoginSuccess
     * @param array $params
     * @return array
     */
    public function testProfileSuccess(array $params): array
    {
        [$user] = $params;

        $uri = self::API_PROFILE;

        $request = Request::create($uri);

        $httpResult = $this->actingAs($user, 'api')
            ->json('GET', $uri, $request->toArray());
        $httpResult->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'email',
                    'user_name',
                    'full_name',
                    'first_name',
                    'last_name',
                    'email_verified_at',
                    'confirmation_code',
                    'confirmed',
                    'timezone',
                    'last_login_at',
                    'last_login_ip',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                ],
                'message',
                'error',
            ]);

        return [$user];
    }

    /**
     * @depends testLoginSuccess
     * @param array $params
     * @return array
     */
    public function testCheckSuccess(array $params): array
    {
        [$user] = $params;

        $uri = self::API_CHECK;

        $request = Request::create($uri);

        $httpResult = $this->actingAs($user, 'api')
            ->json('GET', $uri, $request->toArray());
        $httpResult->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'data' => [],
                'message',
                'error',
            ]);

        return [$user];
    }

    /**
     * @depends testProfileSuccess
     * @param array $params
     * @return array
     */
    public function testLogoutSuccess(array $params): array
    {
        [$user] = $params;

        $uri = self::API_LOGOUT;

        $request = Request::create($uri);

        $httpResult = $this->actingAs($user, 'api')
            ->json('GET', $uri, $request->toArray());
        $httpResult->assertStatus(Response::HTTP_OK)
            ->assertContent(json_encode([
                'status'  => 'success',
                'data'    => [],
                'message' => __('auth.logout.success'),
                'error'   => null,
            ]));

        return [$user];
    }
}
