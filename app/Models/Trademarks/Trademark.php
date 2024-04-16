<?php

namespace App\Models\Trademarks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trademark extends Model
{
    use HasFactory;

    protected $table = 'trademarks';

    protected $primaryKey = 'trademark_id';

    protected $fillable = [
        'trademark_uuid',
        'trademark',
        'trademark_code',
        'active',
    ];

    protected $hidden = ['trademark_id'];
}
