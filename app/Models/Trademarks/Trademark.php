<?php

namespace App\Models\Trademarks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trademark extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trademarks';

    protected $primaryKey = 'trademark_id';

    protected $fillable = [
        'trademark_uuid',
        'trademark',
        'trademark_code',
        'trademark_category_id',
        'active',
    ];

    protected $hidden = ['trademark_id', 'trademark_category_id'];


    /**
     * Retrieve all models associated with this trademark.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function models(): HasMany
    {
        return $this->hasMany(TrademarkModel::class, 'trademark_id');
    }
}
