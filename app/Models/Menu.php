<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = "mst_menus";

    protected $fillable = [
        'menu_name',
        'menu_icon',
        'menu_route',
        'menu_seq',
        'menu_status',
        'module_id',
        'created_by',
        'updated_at'
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        "menu_seq" => "integer",
        "module_id" => "integer",
        "created_by" => "integer",
        "updated_by" => "integer",
    ];
}
