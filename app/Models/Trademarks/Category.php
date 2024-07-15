<?php
/**
 * Trademark Categories Model.
 *
 *
 * @author   Luis Adrian Olvera Facio
 *
 * @version  1.0
 *
 * @since    2024.1
 */

namespace App\Models\Trademarks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_trademarks';
    protected $primaryKey = 'ct_trademark_id';
    protected $fillable = [
        'ct_trademark_uuid',
        'ct_trademark',
        'ct_trademark_code',
        'active',
    ];
    protected $hidden = ['ct_trademark_id'];

    /**
     * Get the trademarks associated with the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trademarks(): HasMany
    {
        return $this->hasMany(Trademark::class, 'ct_trademark_id', 'ct_trademark_id');
    }
}
