<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection LaravelUnknownEloquentFactoryInspection */

namespace App\Models\Equipments;

use App\Models\Status\Status;
use App\Models\Trademarks\Trademark;
use App\Models\Trademarks\TrademarkModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'equipments';

    protected $primaryKey = 'equipment_id';

    protected $fillable = [
        'equipment_uuid',
        'equipment',
        'equipment_code',
        'serial_number',
        'equipment_image',
        'equipment_diagram',
        'model',
        'trademark',
        'manual',
        'ct_equipment_id',
        'status_id',
        'active',
    ];

    protected $hidden = ['equipment_id', 'ct_equipment_id', 'status_id'];

    /**
     * Get the category that this equipment belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'ct_equipment_id', 'ct_equipment_id');
    }

    /**
     * Get the status that this application belongs to.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }
}
