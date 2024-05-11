<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReserveOptionList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reserve_id',
        'reserve_option_id'
    ];

    public function reserveOption(){
        return $this->belongsTo(ReserveOption::class);
    }
}
