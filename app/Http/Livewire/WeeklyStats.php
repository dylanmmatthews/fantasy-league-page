<?php

namespace App\Http\Livewire;

use App\Models\DevyPlayer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;
use Livewire\Component;

/**
 * Summary of WeeklyStats
 */
class WeeklyStats extends Component
{
    public Collection $stats;

    public DevyPlayer $devyPlayer;
    public function render()
    {
        return view('livewire.weekly-stats');
    }
}