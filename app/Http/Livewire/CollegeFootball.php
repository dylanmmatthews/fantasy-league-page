<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CollegeFootball extends Component
{
    public $teamPlayers;
    public function render()
    {
        return view('livewire.college-football');
    }
}
