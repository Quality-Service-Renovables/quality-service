<?php

namespace App\Models\Equipments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'equipment_categories';
    protected $primaryKey = 'equipment_category_id';
    protected $fillable = [
        'equipment_category_uuid',
        'equipment_category',
        'equipment_category_code',
        'description',
        'active',
    ];
}
