<?php

namespace App\Models\Projects;

use App\Models\Application\Log;
use App\Models\Status\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audits extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project_audits';

    protected $primaryKey = 'project_audit_id';

    protected $fillable = [
        'project_audit_uuid',
        'project_id',
        'status_id',
        'application_log_id',
        'comments',
    ];

    protected $hidden = ['project_audit_id', 'project_id', 'status_id', 'application_log_id'];

    /**
     * Get the client associated with the inspection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyect(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    /**
     * Get the category that belongs to this model.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }

    /**
     * Get the equipment associated with the inspection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function log(): HasMany
    {
        return $this->hasMany(Log::class, 'equipment_id', 'equipment_id');
    }
}
