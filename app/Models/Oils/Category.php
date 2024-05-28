<?php

/** @noinspection UnknownInspectionInspection */
/** @noinspection LaravelUnknownEloquentFactoryInspection */

namespace App\Models\Oils;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ct_oils';
    protected $primaryKey = 'ct_oil_id';
    protected $fillable = [
        'ct_oil_uuid',
        'ct_oil',
        'ct_oil_code',
        'description',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
    protected $hidden = ['ct_oil_id'];
}
