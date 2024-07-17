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

class ProjectEmployee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project_employees';

    protected $primaryKey = 'project_id';

    protected $fillable = [
        'project_employee_uuid',
        'user_id',
        'project_id',
    ];

    protected $hidden = ['project_id', 'user_id'];

    /**
     * Get the category that this equipment belongs to.
     */
    public function project(): HasMany
    {
        return $this->hasMany(Project::class, 'project_id', 'project_id');
    }
}
