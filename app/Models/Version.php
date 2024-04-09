<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    protected $table = 'application_versions';
    protected $primaryKey = 'application_version_id';
    protected $fillable = [
        'application_version_uuid',
        'version',
    ];
}
