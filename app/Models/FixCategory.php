<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixCategory extends Model
{
    use HasFactory;
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
