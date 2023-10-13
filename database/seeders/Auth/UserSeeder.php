<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use App\Support\UserRole;
use Database\Factories\UserProfileFactory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = config('users');

        if (empty($users)) {
            return;
        }

        foreach ($users as $user) {
            $this->createUser(
                $user['username'],
                $user['password'],
                $user['email'],
                $user['name'],
                $user['role'] ?? UserRole::NORMAL_USER
            );
        }

        $this->generateFakeUser();
    }

    private function createUser(string $userName, string $password, string $email, string $name, string $role): void
    {
        $user = User::query()->where('user_name', '=', $userName)->first();

        if ($user instanceof User) {
            return;
        }

        /** @var User $user */
        $user = User::factory()
            ->has(UserProfileFactory::new(), 'profile')
            ->asUser($userName, $password, $email, $name)
            ->create();
        $user->assignRole($role);
    }

    private function generateFakeUser(): void
    {
        // Create 100 normal users.
        for ($i = 0; $i < 50; $i++) {
            /** @var User $fakeUser */
            $fakeUser = User::factory()
                ->has(UserProfileFactory::new(), 'profile')
                ->create();
            $fakeUser->assignRole(UserRole::NORMAL_USER);
        }
    }
}
