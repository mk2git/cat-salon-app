<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body_check_id',
        'cat_name',
        'cat_species',
        'weight',
        'message'
    ];

    public function body_check(){
        return $this->hasOne(BodyCheck::class);
    }
}
