<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Illuminate\Http\Request;

class ScheduleController extends Controller{
    public function index(){return Schedule::all();}
    public function show(Schedule $schedule){return $schedule;}
    public function store(Request $request){return Schedule::create($request->all());}
    public function update(Request $request, Schedule $schedule){$schedule->update($request->all());return $schedule;}
    public function destroy(Schedule $schedule){$schedule->delete();return $schedule;}
}
