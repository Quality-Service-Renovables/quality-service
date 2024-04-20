<?php

namespace App\Models\Supervisions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupervisionCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'service_categories';
    protected $primaryKey = 'service_category_id';
    protected $fillable = [
        'service_category_uuid',
        'service_category',
        'service_category_code',
        'description',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
}
