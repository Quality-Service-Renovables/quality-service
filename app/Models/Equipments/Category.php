<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection LaravelUnknownEloquentFactoryInspection */

namespace App\Models\Equipments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'equipment_categories';

    protected $primaryKey = 'equipment_category_id';

    protected $fillable = [
        'equipment_category_uuid',
        'equipment_category',
        'equipment_category_code',
        'description',
        'active',
    ];

    protected $hidden = ['equipment_category_id'];
}
