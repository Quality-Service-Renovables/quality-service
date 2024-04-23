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
    protected $table = 'oil_categories';
    protected $primaryKey = 'oil_category_id';
    protected $fillable = [
        'oil_category_uuid',
        'oil_category',
        'oil_category_code',
        'description',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
    protected $hidden = ['oil_category_id'];
}
