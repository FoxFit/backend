<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImportFile implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $existingUser = User::where('email', $row['email'])
                            ->where('user_name', $row['user_name'])
                            ->first();

        if ($existingUser) return null;

        return new User([
            'email' => $row['email'],
            'user_name' => $row['user_name'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'full_name' => $row['full_name'],
            'password' => $row['password'],
            'email_verified_at' => $row['email_verified_at'],
            'confirmation_code' => $row['confirmation_code'],
            'timezone' => $row['timezone'],
            'last_login_at' => $row['last_login_at'],
            'last_login_ip' => $row['last_login_ip'],
        ]);
    }
}
