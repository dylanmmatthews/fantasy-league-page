<?php

namespace App\Libraries\Sleeper;

use App\Exceptions\SleeperApiException;
use Illuminate\Support\Facades\Http;

class SleeperClient
{
    private string $url = 'https://api.sleeper.app/v1';
    private string $testUrl = 'https://api.collegefootballdata.com/';

    private Http $httpClient;

    /**
     * get
     *
     * @param  mixed  $path
     */
    private function get(string $path): mixed
    {
        $response = Http::get($this->url.$path);

        if ($response->failed()) {
            throw new SleeperApiException($response->body(), $response->status());
        }

        return $response->json();
    }

    public function getListOfTeams () 
    {
        $response = Http::withHeaders([
            'accpet' => 'application/json',
            'Authorization' => 'Bearer bzjVT6ySkvMaTk3JbhjBwZQgttdJhrOpsNqR9T1Nn4+yZeog+K+oft13igO6AwBK'
        ])->get($this->testUrl . 'games/players?year=2023&week=1&seasonType=regular&gameId=401523989');
        return $response->json();
    }
    //4685472 tet mcmillan

    /**
     * league
     *
     * @param  mixed  $leagueId
     */
    public function league(string $leagueId): mixed
    {
        $response = $this->get('/league/'.$leagueId);

        return $response;
    }

    /**
     * leagueUsers
     *
     * @param  mixed  $leagueId
     */
    public function leagueUsers(string $leagueId): mixed
    {
        return $this->get('/league/'.$leagueId.'/users');
    }

    /**
     * @return array
     *
     * @throws SleeperApiException
     */
    public function rosters(string $leagueId): mixed
    {
        return $this->get('/league/'.$leagueId.'/rosters');
    }

    /**
     * fetchAllPlayers
     */
    public function fetchAllPlayers(): mixed
    {
        return $this->get('/players/nfl');
    }
}
