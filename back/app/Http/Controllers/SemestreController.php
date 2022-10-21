<?php

namespace App\Http\Controllers;

use App\Models\Semestre;
use App\Http\Requests\StoreSemestreRequest;
use App\Http\Requests\UpdateSemestreRequest;
use Illuminate\Http\Request;
class SemestreController extends Controller
{
    public function index(){return Semestre::all();}
    public function create(){}
    public function store(Request $request){Semestre::create($request->all());}
    public function show(Semestre $semestre,Request $request){return Semestre::whereUser_id($request->user()->id)->get();}
    public function edit(Semestre $semestre){}
    public function update(Request $request, Semestre $semestre){$semestre->update($request->all());}
    public function destroy(Semestre $semestre){$semestre->delete();}
}
