<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Teacher extends Model
{
    protected $fillable = ['name','balance'];

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    public function absents(){
        return $this->hasMany(Absent::class);
    }
    public function substitute(){
        return $this->hasMany(Substitute::class);
    }
    

}
