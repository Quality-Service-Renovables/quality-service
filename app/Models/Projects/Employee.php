<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection LaravelUnknownEloquentFactoryInspection */

namespace App\Models\Projects;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project_employees';

    protected $primaryKey = 'project_employee_id';

    protected $fillable = [
        'project_employee_uuid',
        'user_id',
        'project_id',
    ];

    protected $hidden = ['project_employee_id', 'project_id', 'user_id'];

    /**
     * Get the category that this equipment belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the status that this application belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }
}
