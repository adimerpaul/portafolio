<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Http\Requests\StoreMateriaRequest;
use App\Http\Requests\UpdateMateriaRequest;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index(Request $request){return Materia::whereUser_id($request->user()->id)->with('semestres')->get();}
    public function create(){}
    public function store(Request $request){Materia::create($request->all());}
    public function show(Materia $materia,Request $request){return Materia::whereUser_id($request->user()->id)->get();}
    public function edit(Materia $materia){}
    public function update(Request $request, $id){
        $material = Materia::find($id);
        $material->nombre = $request->nombre;
        $material->save();
        return $material;
    }
    public function destroy($id){
        $material = Materia::find($id);
        $material->delete();
        return $material;
    }
}
