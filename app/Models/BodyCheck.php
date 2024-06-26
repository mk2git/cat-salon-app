<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cat_name'
    ];

    public function record(){
        return $this->belongsTo(Record::class);
    }
}
