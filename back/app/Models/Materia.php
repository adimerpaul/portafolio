<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'user_id',
    ];
    public function semestres(){
        return $this->hasMany(Semestre::class)->with('documentos.registros');
    }
}
