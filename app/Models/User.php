<?php

namespace App\Models;

use App\Traits\HasUser;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $email
 * @property string $user_name
 * @property string $full_name
 * @property string $first_name
 * @property string $last_name
 * @property string $email_verified_at
 * @property string $password
 * @property string $confirmation_code
 * @property string $confirmed
 * @property string $timezone
 * @property string $last_login_at
 * @property string $last_login_ip
 * @property string $deleted_at
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property UserProfile $profile
 */
class User extends Authenticatable implements \App\Contracts\User
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use HasRoles;
    use HasUser;

    public const ENTITY_TYPE = 'user';

    /**
     * This is use for roles, permissions. Please do not remove this.
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'email',
        'full_name',
        'first_name',
        'last_name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class, 'id', 'id');
    }
}
