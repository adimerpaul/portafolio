<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','semestre_id'];
    public function registros(){ return $this->hasMany(Registro::class);}
}
