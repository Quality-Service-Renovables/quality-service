<?php

namespace App\Models\Failures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Failure extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'failures';

    protected $primaryKey = 'failure_id';

    protected $fillable = [
        'failure_uuid',
        'failure',
        'failure_code',
        'description',
        'active',
        'failure_category_id',
    ];

    /**
     * Get the category that this model belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'failure_category_id', 'failure_category_id');
    }
}
