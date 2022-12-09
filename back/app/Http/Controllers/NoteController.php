<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use Illuminate\Http\Request;

class NoteController extends Controller {
    public function index(){return Note::all();}
    public function show(Note $note){return $note;}
    public function store(Request $request){
        foreach ($request->records as $record){
            $note = new Note();
            $note->student_id = $record['student_id'];
            $note->materia_id = $record['materia_id'];
            $note->record_id = $record['record_id'];
            $note->note = $record['note'];
            $note->description = $request->description;
            $note->save();
        }
    }
    public function update(Request $request, Note $note){$note->update($request->all());return $note;}
    public function destroy(Note $note){$note->delete();return $note;}
}
