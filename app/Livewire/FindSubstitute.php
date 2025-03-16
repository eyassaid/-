<?php

namespace App\Livewire;

use App\Models\Substitute;
use App\Models\Teacher;
use Livewire\Component;

class FindSubstitute extends Component
{
    public $time_table_id;
    public $substitute_id;
    public $teacher_id;
    public $edit = false;

    public function confirmSelection(){
        $substitute = Substitute::find($this->substitute_id);
        $substitute->update(['teacher_id'=>$this->teacher_id]);
        return to_route('schedule.index');
    }
    public function update(){
        $substitute = Substitute::find($this->substitute_id);
        $substitute->update(['teacher_id'=>$this->teacher_id]);
        return to_route('schedule.index');
    }
    public function render()
    {

        return view('livewire.find-substitute');
    }
}
