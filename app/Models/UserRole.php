<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = "mst_user_roles";

    protected $fillable = [
        'user_id',
        'role_id',
        'user_role_status'
    ];

    public function menus()
    {
        return $this->hasManyThrough(
            "App\Models\RoleMenu",
            "App\Models\Menu",
            "module_id",
            "menu_id",
            "id",
            "id"
        )
            ->join("mst_user_roles as a", "mst_rolemenus.role_id", "a.role_id")
            ->where("mst_rolemenus.rolemenu_status", "ACTIVE")
            ->where("menu_status", "ACTIVE")
            ->groupBy("menu_id")
            ->orderBy('menu_seq', 'asc');
    }
}
