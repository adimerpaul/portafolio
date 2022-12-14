<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'last',
        'code',
        'birthday',
        'phone',
        'email',
        'avatar',
        'user_id',
    ];
    public function materias(){
        return $this->belongsToMany(Materia::class);
    }
}
