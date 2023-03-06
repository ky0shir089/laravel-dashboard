<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uid',
        'name',
        'password',
        'fonnte_token',
        'chpass',
        'status',
        'created_by',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //
    ];

    public function user_roles()
    {
        return $this->hasMany(UserRole::class)
            ->join("mst_roles as a", "mst_user_roles.role_id", "a.id");
    }

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            UserRole::class,
            "user_id",
            "role_id"
        );
    }
}
