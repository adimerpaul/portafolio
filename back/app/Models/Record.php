<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $fillable=[
        'student_id',
        'materia_id',
    ];
    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function materia(){
        return $this->belongsTo(Materia::class);
    }
    public function notes(){
        return $this->hasMany(Note::class);
    }
    public function attendance(){
        return $this->hasMany(Attendance::class);
    }
}
