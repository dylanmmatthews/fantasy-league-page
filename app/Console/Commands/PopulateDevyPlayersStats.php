<?php

namespace App\Console\Commands;

use App\Libraries\CollegeFootball\CollegeFootballClient;
use App\Models\DevyPlayer;
use App\Models\WeeklyDevyStats;
use App\Services\ParseCollegeFootballStatsService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class PopulateDevyPlayersStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-devy-players-stats { --week=1 : the week to get the stats for}';

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
        $listOfTeams = collect(config('devy'))->keys();
        $listOfTeams->add('all');
        $teams = $this->choice('Which team stats would you like to fill?', $listOfTeams->all(), 'all');
        if ($teams === 'all') {
            $teams = collect(config('devy'))->keys();
        } else {
            $teams = collect([$teams]);
        }
        $week = $this->option('week');
        $client = new CollegeFootballClient();
        $service = new ParseCollegeFootballStatsService();
        $teamPlayers = $teams->map(function ($team) use ($client, $service, $week) {
            return collect(config('devy.' . $team))->map(function (array $player) use ($week, $client) {
                $player['gameId'] = Arr::get($client->getWeekGames($week, Arr::get($player, 'team')), '0.id', 0);
                return $player;
            })->mapWithKeys(function ($player) use ($client, $service) {
                $game = $client->getIndividualGameStatsForPlayer(Arr::get($player, 'gameId'), Arr::get($player, 'team'));
                return [Arr::get($player, 'name', '') => collect($service->cleanGameStats($game, $player))];
            });
        })->each(function ($globalStats) use ($week, $service) {
            $globalStats->each(function ($stats, $playerName) use ($week, $service) {
                $player = DevyPlayer::where('name', $playerName)->first();
                $statToSave = $service->prepStatsForSave($stats);
                $statToSave['week'] = $week;
                $statToSave['devy_player_id'] = $player->id;
                $weeklyStat = new WeeklyDevyStats($statToSave);
                $player->weeklyDevyStats()->upsert($weeklyStat->toArray(), ['week', 'year', 'devy_player_id']);
                $this->info(sprintf('Player: %s has their stats saved for week %s.', $player->name, $week));
            });
        });


    }
}