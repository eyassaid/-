<?php

namespace App\Http\Controllers;

use App\Models\Absent;
use App\Models\Substitute;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubstituteController extends Controller
{
    private $days =  ['Saturday'=>'السبت','Sunday'=>'الاحد', 'Monday'=>'الاثنين','Tuesday'=>'الثلاثاء','Wednesday'=> 'الاربعاء',
    'Thursday'=> 'الخميس','Friday'=>'الجمعة'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $date = (Carbon::now()->format('Y-m-d'));
        $day = $this->days[Carbon::now()->dayName];
        /**
         * اغراض التجريب
         * 
         */
        // $date = '2025-03-16';
        // $day = $this->days['Sunday'];
        $absentTeachers = Substitute::with(['absent','teacher','section','timeTable'])
        // ->leftJoin('time_tables','substitutes.time_table_id','=','time_tables.id')
        ->select('substitutes.*')
        ->whereHas('absent',function($query) use($date){
            $query->where('date',$date);
        })->orderBy('absent_id')->get();
        return view('substitute.index',['substitutions'=>$absentTeachers,'day'=>$day]);
        
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, Substitute $substitute)
    {
        // اذا تم تبديل المعلم سوف يرجع رصيد المعلم للرصيد السابق
        if($substitute?->teacher_id){
            $teacher = Teacher::find($substitute->teacher_id);
            
            $teacher->update(['balance'=>$teacher->balance +1]);
        }

        $request->validate(['teacher_id'=>'required']);
        $substitute->update(['teacher_id'=>$request->teacher_id]);
        $teacher = Teacher::find($request->teacher_id);
        $teacher->update(['balance'=>$teacher->balance -1]);
        return to_route('substitute.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
