<?php

namespace App\Libraries\CollegeFootball;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CollegeFootballClient
{
    private string $url = 'https://api.collegefootballdata.com/';

    public function getWeekGames(string $week = '1', string $team = '')
    {
        $response = Http::withHeaders([
            'accpet' => 'application/json',
            'Authorization' => 'Bearer bzjVT6ySkvMaTk3JbhjBwZQgttdJhrOpsNqR9T1Nn4+yZeog+K+oft13igO6AwBK'
        ])->get($this->url . 'games?year=2023&week=' . $week . '&seasonType=regular&team=' . urlencode(strtolower($team)));
        return $response->json();
    }
    //4685472 tet mcmillan
// games/players?year=2023&week=1&seasonType=regular&gameId=401523989

    public function getIndividualGameStatsForPlayer($gameId, string $team = '')
    {
        $response = Http::withHeaders([
            'accpet' => 'application/json',
            'Authorization' => 'Bearer bzjVT6ySkvMaTk3JbhjBwZQgttdJhrOpsNqR9T1Nn4+yZeog+K+oft13igO6AwBK'
        ])->get($this->url . 'games/players?year=2023&week=1&category=offensive&seasonType=regular&gameId=' . $gameId . '&team=' . urlencode(strtolower($team)));
        return $response->json();
    }

    public function getTeams()
    {
        $query = urlencode(strtolower('sec'));
        $response = Http::withHeaders([
            'accpet' => 'application/json',
            'Authorization' => 'Bearer bzjVT6ySkvMaTk3JbhjBwZQgttdJhrOpsNqR9T1Nn4+yZeog+K+oft13igO6AwBK'
        ])->get($this->url . 'teams?conference=' . $query);
        return $response->json();
    }

    /**
     * all the ncaa football weeks with start and end times
     *
     * @return void
     */
    public function calendar()
    {
        $response = Http::withHeaders([
            'accpet' => 'application/json',
            'Authorization' => 'Bearer bzjVT6ySkvMaTk3JbhjBwZQgttdJhrOpsNqR9T1Nn4+yZeog+K+oft13igO6AwBK'
        ])->get($this->url . 'calendar?year=2023');
        return $response->json();
    }

}