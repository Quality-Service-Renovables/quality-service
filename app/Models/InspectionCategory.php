<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionCategory extends Model
{
    use HasFactory;
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
}
