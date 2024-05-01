<?php

namespace App\Models\Maintenances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'maintenance_categories';
    protected $primaryKey = 'maintenance_category_id';
    protected $fillable = [
        'maintenance_category_uuid',
        'maintenance_category',
        'maintenance_category_code',
        'description',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
}
