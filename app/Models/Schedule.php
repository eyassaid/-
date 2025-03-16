<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    protected $fillable = ['teacher_id','time_table_id','section_id'];

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function timeTable(){
        return $this->belongsTo(TimeTable::class);
    }
    public function scopeFindClasses(Builder $query,$day){
            return $query->whereHas('timeTable',function(Builder $query) use($day){
                $query->where('days',$day);
            } );
    }
    public static function scopeFreeClass(){
        return DB::table('schedules')
        ->rightJoin('time_tables','schedules.time_table_id','=','time_tables.id')
        ->whereNull('schedules.time_table_id')
        ->get();
    }
    public static function freeTeachers($timeTableId){
      
        return  DB::select(
            "
            select DISTINCT t.name,t.id from teachers t 
            join schedules s on  s.teacher_id = t.id
            where s.teacher_id not in (select teacher_id from schedules where time_table_id = ?)
            order by t.balance desc
            "
        ,[$timeTableId]
        );
    }
      // return DB::table('teachers')
        // ->leftJoin('schedules','schedules.time_table_id','=','teachers.id')
        // ->whereNotIn('schedules.teacher_id',function($query)use($timeTableId){
        //     $query->where('schedules.time_table_id','=',$timeTableId);
        // })->get()
        // ;
}