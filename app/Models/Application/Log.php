<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'application_logs';
    protected $primaryKey = 'application_log_id';
    protected $fillable = [
        'application_log_uuid',
        'request_url',
        'request_received',
        'request_response',
        'module',
        'description',
        'user_id',
    ];
}
