<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    protected $fillable = [
        'client_uuid',
        'client',
        'client_code',
        'logo',
        'legal_name',
        'address',
        'zip_code',
        'phone',
        'phone_office',
        'open_time',
        'close_time',
        'office_days',
        'website',
        'email',
        'active',
    ];
    protected $hidden = ['client_id'];

    /**
     * Get the related configuration for the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function config(): BelongsTo
    {
        return $this->belongsTo(Config::class, 'client_id', 'client_id');
    }
}
