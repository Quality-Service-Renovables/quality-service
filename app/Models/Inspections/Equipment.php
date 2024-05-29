<?php

namespace App\Models\Inspections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inspection_equipments';
    protected $primaryKey = 'inspection_equipment_id';
    protected $fillable = [
        'inspection_equipment_uuid',
        'inspection_id',
        'equipment_id',
    ];
    protected $hidden = ['inspection_equipment_id', 'inspection_id', 'equipment_id'];

    /**
     * Get the equipment associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Equipments\Equipment::class, 'equipment_id', 'equipment_id');
    }
}
