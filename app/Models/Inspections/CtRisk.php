<?php

namespace App\Models\Inspections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtRisk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_risks';

    protected $primaryKey = 'ct_risk_id';

    protected $fillable = [
        'ct_risk_id',
        'ct_risk_uuid',
        'ct_risk',
        'ct_description',
        'ct_description_secondary',
        'ct_color',
    ];
}
