<?php
namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Summary of ParseCollegeFootballStatsService
 */
class ParseCollegeFootballStatsService
{
    public function cleanGameStats(array $game, array $player)
    {
        $gameOverride = collect(Arr::get($game, '0.teams'))->filter(function ($team) use ($player) {
            return strtolower(Arr::get($team, 'school')) === strtolower(Arr::get($player, 'team'));
        })->first();
        $stats = [];
        if ($gameOverride) {
            foreach (Arr::get($gameOverride, 'categories') as $category) {
                if (Arr::get($category, 'name') !== 'defensive') {
                    $stats[Arr::get($category, 'name')] = collect(Arr::get($category, 'types', []))->mapWithKeys(function ($type) use ($player) {
                        return [$type['name'] => collect(Arr::get($type, 'athletes'))->where('name', 'ilike', $player['name'])];
                    })->map(function ($stat) {
                        return collect($stat)->value('stat');
                    })->filter();
                }
            }
        }
        return $stats;
    }

    /**
     * Summary of prepStatsForSave
     * @param Collection $stats
     * @return array
     */
    public function prepStatsForSave(Collection $stats): array
    {
        $tempStats = $stats->map(function ($statSection, $key) {
            $tempArray = [];
            switch ($key) {
                case 'fumbles':
                    $tempArray['fumbles'] = Arr::get($statSection->all(), 'FUM', 0);
                    break;
                case 'receiving':
                    $tempArray['receiving_yards'] = Arr::get($statSection->all(), 'YDS', 0);
                    $tempArray['receiving_catches'] = Arr::get($statSection->all(), 'REC', 0);
                    $tempArray['receiving_long'] = Arr::get($statSection->all(), 'LONG', 0);
                    $tempArray['receiving_touchdowns'] = Arr::get($statSection->all(), 'TD', 0);
                    $tempArray['receiving_average'] = Arr::get($statSection->all(), 'AVG', 0);
                    break;
                case 'rushing':
                    $tempArray['rushing_carries'] = Arr::get($statSection->all(), 'CAR', 0);
                    $tempArray['rushing_yards'] = Arr::get($statSection->all(), 'YDS', 0);
                    $tempArray['rushing_long'] = Arr::get($statSection->all(), 'LONG', 0);
                    $tempArray['rushing_touchdowns'] = Arr::get($statSection->all(), 'TD', 0);
                    $tempArray['rushing_average'] = Arr::get($statSection->all(), 'AVG', 0);
                    break;
                case 'passing':
                    $tempArray['passing_completion_attempts'] = Arr::get($statSection->all(), 'C/ATT', '0/0');
                    $tempArray['passing_yards'] = Arr::get($statSection->all(), 'YDS', 0);
                    $tempArray['passing_touchdowns'] = Arr::get($statSection->all(), 'TD', 0);
                    $tempArray['passing_average'] = Arr::get($statSection->all(), 'AVG', 0);
                    $tempArray['passing_qbr'] = Arr::get($statSection->all(), 'QBR', 0);
                    break;
                case 'puntReturns':
                    $tempArray['punt_returns_attempts'] = Arr::get($statSection->all(), 'NO', 0);
                    $tempArray['punt_returns_yards'] = Arr::get($statSection->all(), 'YDS', 0);
                    $tempArray['punt_returns_long'] = Arr::get($statSection->all(), 'LONG', 0);
                    $tempArray['punt_returns_touchdowns'] = Arr::get($statSection->all(), 'TD', 0);
                    $tempArray['punt_returns_average'] = Arr::get($statSection->all(), 'AVG', 0);
                    break;
                case 'kickReturns':
                    $tempArray['kick_returns_attempts'] = Arr::get($statSection->all(), 'NO', 0);
                    $tempArray['kick_returns_yards'] = Arr::get($statSection->all(), 'YDS', 0);
                    $tempArray['kick_returns_long'] = Arr::get($statSection->all(), 'LONG', 0);
                    $tempArray['kick_returns_touchdowns'] = Arr::get($statSection->all(), 'TD', 0);
                    $tempArray['kick_returns_average'] = Arr::get($statSection->all(), 'AVG', 0);
                    break;
            }
            return $tempArray;
        });
        $finishedStats = array_merge(
            $tempStats->get('fumbles', []),
            $tempStats->get('receiving', []),
            $tempStats->get('rushing', []),
            $tempStats->get('passing', []),
            $tempStats->get('puntReturns', []),
            $tempStats->get('kickReturns', [])
        );
        return $finishedStats;
    }
}