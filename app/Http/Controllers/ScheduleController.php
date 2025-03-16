<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($teacherOrSection)
    {
        if (request()->routeIs('teacher.schedule.index')){
            $teacher = Teacher::find($teacherOrSection);
            $schedules = $teacher->schedules()->orderBy('time_table_id')->get();
            // dd($schedules);
        }else{
            $section = Section::find($teacherOrSection);
            $schedules = $section->schedules()->get();
        }
        return view('schedule.index',['schedules'=>$schedules,'section'=>$section ?? null,'teacher'=>$teacher ?? null ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Teacher $teacher)
    {
       
        return view('schedule.create',['teacher'=>$teacher]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Teacher $teacher)
    {
             $request->validate(
            [
                'section_id'=>'required|integer|exists:sections,id',
                'time_table_id'=>'required|array',
            ]
            );
            foreach ($request['time_table_id'] as $time_table_id){
                $teacher->schedules()->create(
                    [
                        'section_id'=>$request['section_id'],
                        'time_table_id'=>$time_table_id
                    ]);

            }
            return to_route('teacher.schedule.index',$teacher);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($teacherOrSection,Schedule $schedule)
    {
        $schedule->delete();
        if (request()->routeIs('teacher.schedule.index'))
        return to_route('teacher.schedule.index',$teacherOrSection);
        return to_route('section.schedule.index',$teacherOrSection);
    }
}
