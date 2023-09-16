<?php

namespace App\Http\Livewire;

use App\Models\Player;
use Livewire\Component;
use Illuminate\Support\Arr;
use App\Libraries\Sleeper\SleeperClient;

class Rosters extends Component
{
    public function render()
    {$sleeperApi = new SleeperClient();
        $leagueId = '917931648921157632';
        $league = $sleeperApi->league($leagueId);
        $rosters = $sleeperApi->rosters($leagueId);
        $leagueUsers = $sleeperApi->leagueUsers($leagueId);

        $teams = collect($leagueUsers)->map(function (array $user) use ($rosters) {

            $roster = collect($rosters)->filter(
                function (array $data) use ($user) {
                    return Arr::get($data, 'owner_id') === Arr::get($user, 'user_id');
                }
            )->map(
                function (array $data) {
                    return Player::whereIn('player_id', Arr::get($data, 'players'))->get();
                }
            );
            $user['roster'] = $roster->first();

            return $user;
        });

        return view('livewire.rosters', [
            'league' => $league,
            'teams' => $teams,
        ]);
    }
}
