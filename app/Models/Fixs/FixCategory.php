<?php

namespace App\Models\Fixs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FixCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_fixs';
    protected $primaryKey = 'ct_fix_id';
    protected $fillable = [
        'ct_fix_uuid',
        'ct_fix',
        'ct_fix_code',
        'description',
        'is_default',
        'dependency',
        'level',
        'active',
    ];
}
