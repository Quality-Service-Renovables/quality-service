<?php

namespace App\Models\AuthGuards;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at'
    ];
}
