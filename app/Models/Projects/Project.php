<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection LaravelUnknownEloquentFactoryInspection */

namespace App\Models\Projects;

use App\Models\Clients\Client;
use App\Models\Inspections\Inspection;
use App\Models\Status\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projects';

    protected $primaryKey = 'project_id';

    protected $fillable = [
        'project_uuid',
        'project_name',
        'title_report',
        'description',
        'comments',
        'active',
        'status_id',
        'client_id',
    ];

    protected $hidden = ['project_id', 'client_id', 'status_id'];

    /**
     * Get the category that this equipment belongs to.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    /**
     * Get the status that this application belongs to.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }

    /**
     * Get the inspections for this project.
     */
    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class, 'project_id', 'project_id');
    }

    /**
     * Get the employees assigned to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'project_id', 'project_id');
    }
}
