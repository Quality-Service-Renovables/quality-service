<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_services';
    protected $primaryKey = 'ct_service_id';
    protected $fillable = [
        'ct_service_uuid',
        'ct_service',
        'ct_service_code',
        'description',
        'level',
        'active',
    ];
}
