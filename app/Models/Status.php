<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status';
    protected $primaryKey = 'status_id';
    protected $fillable = [
        'status_uuid',
        'status',
        'status_code',
        'description',
        'active',
    ];

    protected $hidden = ['status_id'];
}
