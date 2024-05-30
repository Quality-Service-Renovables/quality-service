<?php

namespace App\Models\Inspections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormInspection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inspection_forms';

    protected $primaryKey = 'inspection_form_id';

    protected $fillable = [
        'inspection_form_uuid',
        'inspection_form',
        'inspection_form_value',
        'inspection_form_comments',
        'inspection_id',
        'ct_inspection_form_id',
    ];

    protected $hidden = ['inspection_id', 'ct_inspection_form_id'];
}
