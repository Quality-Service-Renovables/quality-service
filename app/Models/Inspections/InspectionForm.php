<?php

namespace App\Models\Inspections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionForm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inspection_forms';

    protected $primaryKey = 'inspection_form_id';

    protected $fillable = [
        'inspection_form_uuid',
        'inspection_form',
        'inspection_form_value',
        'inspection_form_comments',
        'inspection_id',
        'ct_inspection_form_id',
        'ct_risk_id',
    ];

    protected $hidden = ['inspection_id', 'ct_inspection_form_id'];

    public function field(): BelongsTo
    {
        return $this->belongsTo(Categories\CtInspectionForm::class, 'ct_inspection_form_id', 'ct_inspection_form_id');
    }

    public function risk(): BelongsTo
    {
        return $this->belongsTo(CtRisk::class, 'ct_risk_id', 'ct_risk_id');
    }
}
