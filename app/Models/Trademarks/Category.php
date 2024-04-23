<?php

namespace App\Models\Trademarks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trademark_categories';
    protected $primaryKey = 'trademark_category_id';
    protected $fillable = [
        'trademark_category_uuid',
        'trademark_category',
        'trademark_category_code',
        'active',
    ];
    protected $hidden = ['trademark_category_id'];
}
