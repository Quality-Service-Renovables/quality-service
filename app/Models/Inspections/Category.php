<?php

namespace App\Models\Inspections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_inspections';
    protected $primaryKey = 'ct_inspection_id';
    protected $fillable = [
        'ct_inspection_uuid',
        'ct_inspection',
        'ct_inspection_code',
        'description',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
    protected $hidden = ['ct_inspection_id'];
}
