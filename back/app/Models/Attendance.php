<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable=[
        'student_id',
        'materia_id',
        'record_id',
        'date',
        'time',
        'status',
        'comment',
    ];
}
