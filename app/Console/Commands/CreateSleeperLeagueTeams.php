<?php

namespace App\Console\Commands;

use App\Models\LeagueTeam;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class CreateSleeperLeagueTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-sleeper-league-teams';

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
        $teams = collect(config('sleeperTeams'));
        $teams->each(function ($team) {
            $createdTeam = LeagueTeam::create([
                'owner_name' => Arr::get($team, 'owner_name'),
                'team_display_name' => Arr::get($team, 'team_display_name')
            ]);
            $this->info(sprintf('Team created ID: %s, team name: %s', $createdTeam->id, $createdTeam->owner_name));
        });
    }
}
