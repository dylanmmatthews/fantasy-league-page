<?php

namespace App\Http\Livewire;

use App\Libraries\Sleeper\SleeperClient;
use App\Models\LeagueTeam;
use Livewire\Component;

class Navigation extends Component
{
    /**
     * league
     *
     * @var mixed
     */
    public $league;

    public function render()
    {
        $sleeperApi = new SleeperClient();
        $leagueId = '917931648921157632';
        $league = $sleeperApi->league($leagueId);
        $leagueTeams = LeagueTeam::all();
        return view('livewire.navigation', ['league' => $league, 'teams' => $leagueTeams]);
    }
}