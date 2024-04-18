<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'inspection_categories';
    protected $primaryKey = 'inspection_category_id';
    protected $fillable = [
        'inspection_category_uuid',
        'inspection_category',
        'inspection_category_code',
        'description',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
    protected $hidden = ['inspection_category_id'];
}
