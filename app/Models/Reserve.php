<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reserve_create_id'
    ];

    public function reserve_create(){
        return $this->belongsTo(ReserveCreate::class, 'reserve_create_id');
    }
}
