<?php

namespace App\Livewire;

use App\Models\Teacher;
use Livewire\Component;

class SearchBar extends Component
{
    public $query = '';
    public function render()
    {   
        $teachers = Teacher::where('name','LIKE',"%$this->query%")->orderBy('balance','desc')->get() ;
        return view('livewire.search-bar',['teachers'=>$teachers]);
    }
}
