<?php

namespace App\Models\Inspections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evidence extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inspection_evidences';

    protected $primaryKey = 'inspection_evidence_id';

    protected $fillable = [
        'inspection_evidence_uuid',
        'inspection_evidence',
        'inspection_evidence_secondary',
        'title',
        'description',
        'title_secondary',
        'description_secondary',
        'inspection_id',
    ];

    protected $hidden = ['inspection_evidence_id', 'inspection_id'];

    /**
     * Get the inspection associated with the model.
     */
    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class, 'inspection_id', 'inspection_id');
    }
}
