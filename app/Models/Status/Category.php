<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection LaravelUnknownEloquentFactoryInspection */

namespace App\Models\Status;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_status';
    protected $primaryKey = 'ct_status_id';
    protected $fillable = [
        'ct_status_uuid',
        'ct_status',
        'ct_status_code',
        'ct_description',
        'ct_active',
    ];

    protected $hidden = ['ct_status_id'];

    /**
     * Get the status for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function status(): HasMany
    {
        return $this->hasMany(Status::class, 'ct_status_id', 'ct_status_id');
    }
}
