<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Http\Requests\StoreRegistroRequest;
use App\Http\Requests\UpdateRegistroRequest;

class RegistroController extends Controller
{
    public function index(){return Registro::with('semestre')->get();}
    public function store(StoreRegistroRequest $request){return Registro::create($request->all());}
    public function show(Registro $registro){return $registro;}
    public function update(UpdateRegistroRequest $request, Registro $registro){$registro->update($request->all());}
    public function destroy(Registro $registro){$registro->delete();}
}
