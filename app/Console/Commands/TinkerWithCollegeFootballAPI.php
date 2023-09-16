<?php

namespace App\Console\Commands;

use App\Libraries\CollegeFootball\CollegeFootballClient;
use App\Libraries\Sleeper\SleeperClient;
use Illuminate\Console\Command;

class TinkerWithCollegeFootballAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tinker-with-college-football-a-p-i';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'tinker with the college football api';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $rest = new CollegeFootballClient();
        // dd($rest->getWeekGames(1, urlencode(strtolower("Texas A&M"))));
        dd($rest->calendar());
    }
}
