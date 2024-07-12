<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_configurations';
    protected $primaryKey = 'client_configuration_id';
    protected $fillable = [
        'client_configuration_uuid',
        'client_id',
        'send_email',
        'invoice_required',
        'send_client_report',
        'crypt_report',
    ];
    protected $hidden = ['client_configuration_id', 'client_id'];
}
