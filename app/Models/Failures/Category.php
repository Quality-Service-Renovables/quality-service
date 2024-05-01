<?php

namespace App\Models\Failures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'failure_categories';
    protected $primaryKey = 'failure_category_id';
    protected $fillable = [
        'failure_category_uuid',
        'failure_category',
        'failure_category_code',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
    protected $hidden = ['failure_category_id'];
}
