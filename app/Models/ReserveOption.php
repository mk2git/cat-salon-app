<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReserveOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fee',
        'description'
    ];

    public function reserveOptionLists(){
        return $this->hasMany(ReserveOptionList::class);
    }
}
