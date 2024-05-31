<?php

namespace App\Models\Inspections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inspections';

    protected $primaryKey = 'inspection_id';

    protected $fillable = [
        'inspection_uuid',
        'resume',
        'conclusion',
        'recomendations',
        'ct_inspection_id',
    ];

    protected $hidden = ['inspection_id', 'ct_inspection_id'];

    /**
     * Get the category that belongs to this model.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'ct_inspection_id', 'ct_inspection_id');
    }

    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class, 'inspection_id', 'inspection_id');
    }

    public function forms(): HasMany
    {
        return $this->hasMany(FormInspection::class, 'inspection_id', 'inspection_id');
    }

    public function evidences(): HasMany
    {
        return $this->hasMany(Evidence::class, 'inspection_id', 'inspection_id');
    }
}
