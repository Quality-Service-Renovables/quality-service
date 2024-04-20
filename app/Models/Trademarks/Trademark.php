<?php

namespace App\Models\Trademarks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trademark extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trademarks';

    protected $primaryKey = 'trademark_id';

    protected $fillable = [
        'trademark_uuid',
        'trademark',
        'trademark_code',
        'active',
    ];

    protected $hidden = ['trademark_id'];


    public function models()
    {
        return $this->hasMany(TrademarkModel::class, 'trademark_id');
    }
}
