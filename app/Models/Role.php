<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = "mst_roles";

    protected $fillable = [
        'role_name',
        'created_by',
        'updated_by'
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        "created_by" => "integer",
        "updated_by" => "integer",
    ];

    public function menus()
    {
        return $this->belongsToMany(
            "App\Models\Menu",
            "App\Models\RoleMenu",
            "role_id",
            "menu_id"
        );
    }
}
