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
        'equipment_image',
        'model',
        'serial_number',
        'work_hours',
        'manufacture_date',
        'barcode',
        'description',
        'manual',
        'equipment_category_id',
        'trademark_id',
        'trademark_model_id',
        'status_id',
        'active',
    ];

    protected $hidden = ['equipment_id', 'equipment_category_id', 'trademark_id', 'trademark_model_id', 'status_id'];

    /**
     * Get the category that this equipment belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'equipment_category_id', 'equipment_category_id');
    }

    /**
     * Get the status that this application belongs to.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }

    /**
     * Get the trademark that this item belongs to.
     */
    public function trademark(): BelongsTo
    {
        return $this->belongsTo(Trademark::class, 'trademark_id', 'trademark_id');
    }

    /**
     * Get the model that this item belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(TrademarkModel::class, 'trademark_model_id', 'trademark_model_id');
    }
}
