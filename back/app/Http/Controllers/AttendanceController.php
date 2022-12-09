<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use Illuminate\Http\Request;

class AttendanceController extends Controller{
    public function index(){return Attendance::all();}
    public function show(Attendance $attendance){return $attendance;}
    public function store(Request $request){
        foreach ($request->records as $record){
            $attendance = new Attendance();
            $attendance->student_id=$record['student_id'];
            $attendance->materia_id=$record['materia_id'];
            $attendance->record_id=$record['record_id'];
            $attendance->date=date('Y-m-d');
            $attendance->time=date('H:i:s');
            $attendance->status=$record['asistencia'];
            $attendance->comment='';
            $attendance->save();
        }
    }
    public function update(Request $request, Attendance $attendance){$attendance->update($request->all());return $attendance;}
    public function destroy(Attendance $attendance){$attendance->delete();return $attendance;}
}
