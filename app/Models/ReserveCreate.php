<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReserveCreate extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'course_id'
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function reserve(){
        return $this->belongsTo(Reserve::class);
    }
}
