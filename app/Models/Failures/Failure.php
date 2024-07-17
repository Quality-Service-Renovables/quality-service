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
        'ct_failure_id',
    ];

    protected $hidden = ['ct_failure_id'];
    /**
     * Get the category that this model belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'ct_failure_id', 'ct_failure_id');
    }
}
