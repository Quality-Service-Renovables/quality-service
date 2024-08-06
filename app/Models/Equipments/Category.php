<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection LaravelUnknownEloquentFactoryInspection */

namespace App\Models\Equipments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_equipments';

    protected $primaryKey = 'ct_equipment_id';

    protected $fillable = [
        'ct_equipment_uuid',
        'ct_equipment',
        'ct_equipment_code',
        'description',
        'required_fields_report',
        'active',
    ];

    protected $hidden = ['ct_equipment_id'];

    /**
     * Retrieve the equipment records associated with the current model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class, 'ct_equipment_id', 'ct_equipment_id');
    }
}
