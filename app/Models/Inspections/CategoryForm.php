<?php

namespace App\Models\Inspections;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inspections\FormInspection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function formInspection()
    {
        return $this->belongsTo(FormInspection::class, 'ct_inspection_form_id', 'ct_inspection_form_id');
    }
}
