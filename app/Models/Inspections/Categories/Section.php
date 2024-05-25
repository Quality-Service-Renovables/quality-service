<?php

namespace App\Models\Inspections\Categories;

use App\Models\Inspections\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_inspection_sections';
    protected $primaryKey = 'ct_inspection_section_id';
    protected $fillable = [
        'ct_inspection_section_uuid',
        'ct_inspection_section',
        'ct_inspection_section_code',
        'ct_inspection_id',
    ];
    protected $hidden = ['ct_inspection_id'];

    /**
     * Get the category that belongs to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'ct_inspection_id', 'ct_inspection_id');
    }
}
