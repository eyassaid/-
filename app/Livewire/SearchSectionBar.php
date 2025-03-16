<?php

namespace App\Livewire;

use App\Models\Section;
use Livewire\Component;

class SearchSectionBar extends Component
{
    public $query = '';
    public function render()
    {
        $sections = Section::where('name', 'LIKE', "%$this->query%")->get();
        return view('livewire.search-section-bar',['sections'=>$sections]);
    }
}
