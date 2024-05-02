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

    protected $table = 'trademark_categories';
    protected $primaryKey = 'trademark_category_id';
    protected $fillable = [
        'trademark_category_uuid',
        'trademark_category',
        'trademark_category_code',
        'active',
    ];
    protected $hidden = ['trademark_category_id'];

    /**
     * Get the trademarks associated with the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trademarks(): HasMany
    {
        return $this->hasMany(Trademark::class, 'trademark_category_id', 'trademark_category_id');
    }
}
