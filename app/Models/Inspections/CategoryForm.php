<?php

namespace App\Models\Inspections;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryForm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ct_inspection_forms';
    protected $primaryKey = 'ct_inspection_form_id';
    protected $fillable = [
        'ct_inspection_form_uuid',
        'ct_inspection_form',
        'ct_inspection_form_code',
        'ct_inspection_section_id',
        'required',
    ];
    protected $hidden = ['ct_inspection_form_id','ct_inspection_section_id'];
}