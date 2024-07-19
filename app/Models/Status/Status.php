<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection LaravelUnknownEloquentFactoryInspection */

namespace App\Models\Status;

use App\Models\Projects\Project;
use App\Models\Projects\ProjectEmployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'status';
    protected $primaryKey = 'status_id';
    protected $fillable = [
        'status_uuid',
        'status',
        'status_code',
        'description',
        'active',
    ];

    protected $hidden = ['status_id', 'ct_status_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'ct_status_id', 'ct_status_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'status_id', 'status_id');
    }
}
