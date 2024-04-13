<?php

namespace App\Models\Equipments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $table = 'equipments';
    protected $primaryKey = 'equipment_id';
    protected $fillable = [
        'equipment_uuid',
        'equipment',
        'equipment_code',
        'equipment_image',
        'model',
        'serial_number',
        'manufacture_date',
        'barcode',
        'description',
        'equipment_category_id',
        'trademark_id',
        'status_id',
        'manual',
        'active',
    ];
}
