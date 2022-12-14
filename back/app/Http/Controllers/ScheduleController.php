<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Illuminate\Http\Request;

class ScheduleController extends Controller{
    public function index(Request $request){return Schedule::where('user_id',$request->user()->id)->get();}
    public function show(Schedule $schedule){return $schedule;}
    public function store(Request $request){
        if (Schedule::where('user_id',$request->user()->id)->where('dia',$request->dia)->where('hora',$request->hora)->count() > 0){
            $schedule = Schedule::where('user_id',$request->user()->id)->where('dia',$request->dia)->where('hora',$request->hora)->first();
            $schedule->materia = $request->materia==null?"":$request->materia;
//            $schedule->sigla = $request->sigla;
            $schedule->save();
        }else{
            return Schedule::create($request->all());
        }
    }
    public function update(Request $request, Schedule $schedule){$schedule->update($request->all());return $schedule;}
    public function destroy(Schedule $schedule){$schedule->delete();return $schedule;}
    public function getSchedule(Request $request){
        return Schedule::where('user_id',$request->user()->id)->get();
    }
}
