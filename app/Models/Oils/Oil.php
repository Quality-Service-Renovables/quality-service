<?php

namespace App\Models\Oils;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oil extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'oils';
    protected $primaryKey = 'oil_id';
    protected $fillable = [
        'oil_id',
        'oil_uuid',
        'oil',
        'oil_code',
        'viscosity',
        'description',
        'oil_category_id',
        'trademark_id',
        'trademark_model_id',
        'production_date',
        'expiration_date',
        'quantity',
        'active',
    ];
    protected $hidden = ['oil_id', 'oil_category_id', 'trademark_id', 'trademark_model_id'];
}
