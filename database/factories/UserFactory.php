<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @method User create($attributes = [], ?Model $parent = null)
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    private function getEmailPrefix(): string
    {
        return config('app.email_prefix');
    }

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $emailPrefix = $this->getEmailPrefix();
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $full_name = $first_name . ' ' . $last_name;
        $user_name = $this->faker->userName;
        $email = $user_name . $emailPrefix;

        return [
            'full_name'         => $full_name,
            'first_name'        => $first_name,
            'last_name'         => $last_name,
            'user_name'         => $user_name,
            'email'             => $email,
            'email_verified_at' => null,
            'password'          => Hash::make('123456'), // password
            'remember_token'    => null,
        ];
    }

    public function asUser(string $username, string $password, string $email = null, string $name = null): UserFactory
    {
        $emailPrefix = $this->getEmailPrefix();

        if ($email === null) {
            $validator = Validator::make(['email' => $username], [
                'email' => 'required|email',
            ]);

            $email = $username;
            if (!$validator->passes()) {
                $email = "{$username}{$emailPrefix}";
            }
        }

        // test admin exists.
        return $this->state(function () use ($username, $password, $email, $name) {
            return [
                'user_name' => $username,
                'full_name' => $name === null ? $username : $name,
                'email'     => $email,
                'password'  => Hash::make($password),
            ];
        });
    }
}
