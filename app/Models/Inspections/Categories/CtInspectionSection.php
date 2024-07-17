<?php

namespace App\Models\Inspections\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtInspectionSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_inspection_sections';

    protected $primaryKey = 'ct_inspection_section_id';

    protected $fillable = [
        'ct_inspection_section_uuid',
        'ct_inspection_section',
        'ct_inspection_section_code',
        'ct_inspection_id',
        'ct_inspection_relation_id',
    ];

    protected $hidden = ['ct_inspection_section_id', 'ct_inspection_id'];

    /**
     * Get the category that belongs to this model.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CtInspection::class, 'ct_inspection_id', 'ct_inspection_id');
    }
    public function subSections()
    {
        return $this->hasMany(__CLASS__, 'ct_inspection_relation_id', 'ct_inspection_section_id');
    }
    public function fields()
    {
        return $this->hasMany(CtInspectionForm::class, 'ct_inspection_section_id', 'ct_inspection_section_id');
    }
}
