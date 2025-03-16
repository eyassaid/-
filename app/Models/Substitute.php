<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Substitute extends Model
{
    protected $fillable = ['teacher_id','absent_id','time_table_id','section_id'];

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }
    
    public function absent(){
        return $this->belongsTo(Absent::class);
    }
    public function timeTable(){
        return $this->belongsTo(TimeTable::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }
}
