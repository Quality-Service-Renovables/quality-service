<?php

namespace App\Models\Supervisions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupervisionCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_services';
    protected $primaryKey = 'ct_service_id';
    protected $fillable = [
        'ct_service_uuid',
        'ct_service',
        'ct_service_code',
        'description',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
}
