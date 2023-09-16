<?php

namespace App\Console\Commands;

use App\Models\DevyPlayer;
use App\Models\LeagueTeam;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

/**
 * PlaceDevyPlayersOnLeagueTeams
 */
class PlaceDevyPlayersOnLeagueTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:place-devy-players-on-league-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        collect(config('devy'))->each(function ($players, $team) {
            $currentTeam = LeagueTeam::where('owner_name', $team)->first();
            collect($players)->each(function ($player) use ($currentTeam) {
                $newPlayer = new DevyPlayer($player);
                $currentTeam->devyPlayer()->save($newPlayer);
                $this->info(sprintf('%s has been saved', Arr::get($player, 'name')));
            });
        });
    }
}