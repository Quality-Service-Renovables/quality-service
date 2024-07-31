<?php

namespace App\Models\Inspections;

use App\Models\Clients\Client;
use App\Models\Inspections\Categories\CtInspection;
use App\Models\Projects\Project;
use App\Models\Status\Status;
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
        'location',
        'escala_condicion',
        'equipment_fields_report',
        'ct_inspection_id',
        'ct_risk_id',
        'client_id',
        'status_id',
        'project_id',
    ];

    protected $hidden = ['inspection_id', 'ct_inspection_id', 'ct_risk_id', 'client_id', 'status_id', 'project_id'];

    /**
     * Get the client associated with the inspection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    /**
     * Get the category that belongs to this model.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CtInspection::class, 'ct_inspection_id', 'ct_inspection_id');
    }

    /**
     * Get the equipment associated with the inspection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Equipments\Equipment::class, 'equipment_id', 'equipment_id');
    }

    public function inspectionEquipments(): HasMany
    {
        return $this->hasMany(Equipment::class, 'inspection_id', 'inspection_id');
    }

    /**
     * Get the forms associated with the inspection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forms(): HasMany
    {
        return $this->hasMany(InspectionForm::class, 'inspection_id', 'inspection_id');
    }

    /**
     * Get the evidences of the inspection.
     */
    public function evidences(): HasMany
    {
        return $this->hasMany(Evidence::class, 'inspection_id', 'inspection_id');
    }

    /**
     * Get the status that belongs to this model.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }

    /**
     * Get the project associated with the inspection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }
}
