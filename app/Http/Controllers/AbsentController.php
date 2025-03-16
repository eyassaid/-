<?php

namespace App\Http\Controllers;

use App\Models\Absent;
use App\Models\Substitute;
use App\Models\Teacher;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AbsentController extends Controller
{
    private $days =  ['Sunday'=>'الاحد', 'Monday'=>'الاثنين','Tuesday'=>'الثلاثاء','Wednesday'=> 'الاربعاء',
    'Thursday'=> 'الخميس'];

    /**
     * Display a listing of the resource.
     */
    public function index(Teacher $teacher)
    {
        $teacher = $teacher->load('schedules');
        return view('absent.index',['teacher'=>$teacher]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Teacher $teacher)
    {
        try{
            /** 
             * صارت عندي مشكلة حيث عند تسجيل الغياب في نفس اليوم يتم تسجيل الغياب للاسبوع القادم
             * لذلك عملت مقارنة اذا كان اليوم مشابه لليوم الفعلي سيتم تسجيل تاريخ اليوم 
             * ام اذا لم يشابه فسيقوم كاربون بإختيار اقرب تاريخ لذلك اليوم
             * */ 
            $day = $request->input('day');
            
            $date = $day == Carbon::now()->dayName ? Carbon::now()->today() : Carbon::now()->next($day)  ;
         

            $day = $this->days[$day];
            $schedules = $teacher->schedules()
            ->whereHas('timeTable',function($query) use($day){$query->where('days',$day);})
            ->get();
           
            $absent = $teacher->absents()->create(['days'=>$day,'date'=>$date->format('Y-m-d')]);
            foreach($schedules as $schedule){
                Substitute::create(
                    [
                        'absent_id'=>$absent->id,
                        'time_table_id'=>$schedule->time_table_id,
                        'section_id'=>$schedule->section->id
                    ]);
                }
                $teacher->update(['balance'=>$teacher->balance + $schedules->count()]);
                return to_route('teacher.index');
            }catch(Exception $e){
                return  to_route('teacher.absent.index',$teacher)->with('خطأ',' لايمكن تسجيل المعلم غياب اكثر من مرة واحدة في اليوم الواحد');
            }

    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
       
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
    public function destroy(Teacher $teacher,Absent $absent)
    {
        $day = $absent->days;
        $schedule = $teacher->schedules()
        ->whereHas('timeTable',function($query) use($day){$query->where('days',$day);})
        ->get();
        $teacher->update(['balance'=>$teacher->balance - $schedule->count()]);
        $absent->delete();
        return to_route('teacher.absent.index',[$teacher]);
    }
}
