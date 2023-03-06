<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = "mst_modules";

    protected $fillable = [
        'module_name',
        'module_icon',
        'module_seq',
        'created_by',
        'updated_at',
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        "module_seq" => "integer",
        "created_by" => "integer",
        "updated_by" => "integer",
    ];
}
