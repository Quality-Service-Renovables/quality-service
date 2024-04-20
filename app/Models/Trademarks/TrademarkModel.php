<?php

namespace App\Models\Trademarks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrademarkModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trademark_models';

    protected $primaryKey = 'trademark_model_id';

    protected $fillable = [
        'trademark_model_uuid',
        'trademark_model',
        'trademark_model_code',
        'active',
        'trademark_id',
    ];

    protected $hidden = ['trademark_model_id', 'trademark_id'];

    /**
     * Get the trademark associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trademark(): BelongsTo
    {
        return $this->belongsTo(Trademark::class, 'trademark_model_id');
    }
}
