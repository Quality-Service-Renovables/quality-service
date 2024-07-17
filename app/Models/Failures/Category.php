<?php

namespace App\Models\Failures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'ct_failures';
    protected $primaryKey = 'ct_failure_id';
    protected $fillable = [
        'ct_failure_uuid',
        'ct_failure',
        'ct_failure_code',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
    protected $hidden = ['ct_failure_id'];
}
