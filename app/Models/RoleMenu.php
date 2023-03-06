<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use HasFactory;

    protected $table = "mst_rolemenus";

    protected $fillable = [
        'role_id',
        'menu_id',
        'rolemenu_status',
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
