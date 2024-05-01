<?php

namespace App\Models\Fixs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FixCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fix_categories';
    protected $primaryKey = 'fix_category_id';
    protected $fillable = [
        'fix_category_uuid',
        'fix_category',
        'fix_category_code',
        'description',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
}
