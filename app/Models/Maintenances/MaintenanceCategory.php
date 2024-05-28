<?php

namespace App\Models\Maintenances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_maintenances';
    protected $primaryKey = 'ct_maintenance_id';
    protected $fillable = [
        'ct_maintenance_uuid',
        'ct_maintenance',
        'ct_maintenance_code',
        'description',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
}
