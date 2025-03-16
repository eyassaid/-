<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    protected $fillable = ['teacher_id','days','date'];
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function substitute(){
        return $this->hasMany(Substitute::class);
    }
}
