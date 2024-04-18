<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    protected $fillable = [
        'client_uuid',
        'client',
        'logo',
        'legal_name',
        'address',
        'zip_code',
        'phone',
        'website',
        'email',
        'active',
    ];
}
