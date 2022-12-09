<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Http\Requests\StoreRecordRequest;
use App\Http\Requests\UpdateRecordRequest;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index(){return Record::with('student')->get();}
    public function show($materia_id){
        return Record::with('notes')
            ->with('student')
            ->with('attendance')
            ->where('materia_id',$materia_id)
            ->get();
    }
    public function store(Request $request){return Record::create($request->all());}
    public function update(Request $request, Record $record){$record->update($request->all());return $record;}
    public function destroy(Record $record){$record->delete();return $record;}
}
