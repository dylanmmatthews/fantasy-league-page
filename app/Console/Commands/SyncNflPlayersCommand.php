<?php

namespace App\Console\Commands;

use App\Libraries\Sleeper\SleeperClient;
use App\Models\Player;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class SyncNflPlayersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-nfl-players-command';

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
        $sleeperClient = new SleeperClient();
        $data = collect($sleeperClient->fetchAllPlayers());
        $data->each(function (array $player) {
            try {
                Player::updateOrCreate($this->cleanData($player));
            } catch (Exception $e) {
                $this->error(sprintf('Player: %s, not synced', Arr::get($player, 'full_name', 'n/a')));
            }
        });

        $this->info(sprintf('NFL players have been synced. Total players, %s', Player::count()));
    }

    private function cleanData(array $data)
    {
        return [
            'player_id' => Arr::get($data, 'player_id', '0'),
            'full_name' => Arr::get($data, 'full_name', 'n/a'),
            'position' => Arr::get($data, 'position', 'n/a'),
            'age' => Arr::get($data, 'age', null),
            'status' => Arr::get($data, 'status', 'Not listed'),
        ];
    }

    private function fakeResponse()
    {
        return [
            [
                'hashtag' => '#TomBrady-NFL-NE-12',
                'depth_chart_position' => 1,
                'status' => 'Active',
                'sport' => 'nfl',
                'fantasy_positions' => ['QB'],
                'number' => 12,
                'search_last_name' => 'brady',
                'injury_start_date' => null,
                'weight' => '220',
                'position' => 'QB',
                'practice_participation' => null,
                'sportradar_id' => '',
                'team' => 'NE',
                'last_name' => 'Brady',
                'college' => 'Michigan',
                'fantasy_data_id' => 17836,
                'injury_status' => null,
                'player_id' => '3086',
                'height' => "6'4",
                'search_full_name' => 'tombrady',
                'age' => 40,
                'stats_id' => '',
                'birth_country' => 'United States',
                'espn_id' => '',
                'search_rank' => 24,
                'first_name' => 'Thomas',
                'depth_chart_order' => 1,
                'years_exp' => 14,
                'rotowire_id' => null,
                'rotoworld_id' => 8356,
                'search_first_name' => 'tom',
                'yahoo_id' => null,
            ],
            [
                'hashtag' => '#TomBrady-NFL-NE-12',
                'depth_chart_position' => 1,
                'status' => 'Active',
                'sport' => 'nfl',
                'fantasy_positions' => ['QB'],
                'number' => 12,
                'search_last_name' => 'brady',
                'injury_start_date' => null,
                'weight' => '220',
                'position' => 'WR',
                'practice_participation' => null,
                'sportradar_id' => '',
                'team' => 'NE',
                'last_name' => 'Doe',
                'college' => 'Nebraska',
                'fantasy_data_id' => 17836,
                'injury_status' => null,
                'player_id' => '9999',
                'height' => "6'4",
                'search_full_name' => 'tombrady',
                'age' => 23,
                'stats_id' => '',
                'birth_country' => 'United States',
                'espn_id' => '',
                'search_rank' => 24,
                'first_name' => 'John',
                'depth_chart_order' => 1,
                'years_exp' => 14,
                'rotowire_id' => null,
                'rotoworld_id' => 8356,
                'search_first_name' => 'tom',
                'yahoo_id' => null,
            ],
        ];
    }
}
