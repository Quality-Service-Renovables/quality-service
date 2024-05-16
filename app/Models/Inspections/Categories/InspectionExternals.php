<?php

namespace App\Models\Inspections\Categories;

use App\Models\Inspections\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspectionExternals extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_inspection_externals';
    protected $primaryKey = 'ct_inspection_external_id';
    protected $fillable = [
        'ct_inspection_external_uuid',
        'ct_inspection_external',
        'ct_inspection_external_code',
    ];
    protected $hidden = ['ct_inspection_section_id'];

    public function section(): BelongsTo
    {
        return $this->belongsTo(InspectionSections::class, 'ct_inspection_section_id', 'ct_inspection_section_id');
    }
}
