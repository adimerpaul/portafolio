<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Http\Requests\StoreDocumentoRequest;
use App\Http\Requests\UpdateDocumentoRequest;

class DocumentoController extends Controller
{
    public function index(){return Documento::with('semestre')->get();}
    public function store(StoreDocumentoRequest $request){return Documento::create($request->all());}
    public function show(Documento $documento){return $documento;}
    public function update(UpdateDocumentoRequest $request, Documento $documento){$documento->update($request->all());}
    public function destroy(Documento $documento){$documento->delete();}
}
