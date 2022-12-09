<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\Request;

class StudentController extends Controller{
    public function index(Request $request){return Student::where('user_id',$request->user()->id)->get();}
    public function show(Student $student){return $student;}
    public function store(Request $request){return Student::create($request->all());}
    public function update(Request $request, Student $student){$student->update($request->all());return $student;}
    public function destroy(Student $student){$student->delete();return $student;}
}
