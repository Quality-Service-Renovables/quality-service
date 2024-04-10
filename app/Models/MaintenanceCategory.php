<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceCategory extends Model
{
    use HasFactory;
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
