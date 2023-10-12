<?php

namespace App\Http\Controllers;

use App\Libraries\CollegeFootball\CollegeFootballClient;
use App\Libraries\Sleeper\SleeperClient;
use App\Models\LeagueTeam;
use App\Models\Player;
use App\Models\WeeklyDevyStats;
use App\Services\ParseCollegeFootballStatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    public function show()
    {
        $sleeperApi = new SleeperClient();
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

        return view('homepage', [
            'league' => $league,
            'teams' => $teams,
        ]);
    }

    public function college()
    {
        $client = new CollegeFootballClient();
        $service = new ParseCollegeFootballStatsService();
        $teams = collect(config('devy'))->keys();
        $teams = collect(['joeross']);
        $teamPlayers = $teams->mapWithKeys(function ($team) use ($client, $service) {
            return [
                $team => collect(config('devy.' . $team))->map(function (array $player) use ($client) {
                    $player['gameId'] = Arr::get($client->getWeekGames(2, Arr::get($player, 'team')), '0.id', 0);
                    return $player;
                })->mapWithKeys(function ($player) use ($client, $service) {
                $game = $client->getIndividualGameStatsForPlayer(Arr::get($player, 'gameId'), Arr::get($player, 'team'));
                return [Arr::get($player, 'name', '') => collect($service->cleanGameStats($game, $player))];
            })
            ];
        });
        return view('college', [
            'teamPlayers' => $teamPlayers
        ]);
    }

    public function team(Request $request, $leagueTeamId)
    {
        $team = LeagueTeam::find($leagueTeamId);
        $devyPlayers = $team->devyPlayer;
        return view('team', [
            'team' => $team,
            'devyPlayers' => $devyPlayers,
            'week' => $request->query('week', 6)
        ]);
    }

    public function leader()
    {
        $playerStats = WeeklyDevyStats::where('week', '=', 2)->orderBy('receiving_yards', 'desc')->paginate(25);
        $playerStats->each(function ($playerStat) {
            dump($playerStat->devyPlayer->name . ': receiving yards ' . $playerStat->receiving_yards);
        });
    }

    public function stats()
    {
        
        return view('stats');
    }
}