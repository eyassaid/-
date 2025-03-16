<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    protected $fillable = ['days','class'];
    public function schedule(){
        return $this->hasMany(Schedule::class);
    }
}
