<?php

namespace App\Http\Livewire;

use App\Models\LeagueTeam;
use App\Models\WeeklyDevyStats;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Enumerable;
use RamonRietdijk\LivewireTables\Actions\Action;
use RamonRietdijk\LivewireTables\Columns\BooleanColumn;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Columns\DateColumn;
use RamonRietdijk\LivewireTables\Columns\ImageColumn;
use RamonRietdijk\LivewireTables\Columns\SelectColumn;
use RamonRietdijk\LivewireTables\Filters\BooleanFilter;
use RamonRietdijk\LivewireTables\Filters\DateFilter;
use RamonRietdijk\LivewireTables\Filters\SelectFilter;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

/**
 * Summary of StatsTable
 */
class StatsTable extends \RamonRietdijk\LivewireTables\Http\Livewire\LivewireTable
{
    protected string $model = WeeklyDevyStats::class;

    protected function columns(): array
    {
        return [
            Column::make(__('Player name'), 'devyPlayer.name')
                ->sortable()
                ->searchable(),

            SelectColumn::make(__('Devy Team'), 'devyPlayer.leagueTeam.team_display_name')
                ->options(
                    LeagueTeam::query()->get()->pluck('team_display_name', 'team_display_name')->toArray()
                )
                ->sortable()
                ->searchable(),

            SelectColumn::make(__('Week'), 'week')
                ->options(
                    WeeklyDevyStats::query()->get()->pluck('week', 'week')->toArray()
                )
                ->searchable(),

            SelectColumn::make(__('Pos'), 'devyPlayer.position')
                ->options([
                    'QB' => 'QB',
                    'RB' => 'RB',
                    'WR' => 'WR',
                    'TE' => 'TE'
                ])
                ->searchable(),

            Column::make(__('c/att'), 'passing_completion_attempts')
                ->sortable(),
            Column::make(__('pass yds'), 'passing_yards')
                ->sortable(),
            Column::make(__('yds/att'), 'passing_average')->sortable(),

            Column::make(__('Rec'), 'receiving_catches')
                ->sortable(),

            Column::make(__('Rec yds'), 'receiving_yards')
                ->sortable(),
            Column::make(__('Rec avg'), 'receiving_average'),

            Column::make(__('Rush att'), 'rushing_carries')
                ->sortable(),
            Column::make(__('Rush yds'), 'rushing_yards')
                ->sortable(),
            Column::make(__('Rush yds/att'), 'rushing_average'),
        ];
    }

    protected function filters(): array
    {
        return [

            SelectFilter::make(__('Devy Team'), 'devyPlayer.leagueTeam.team_display_name')
                ->options(
                    LeagueTeam::query()->get()->pluck('team_display_name', 'team_display_name')->toArray()
                ),

            SelectFilter::make(__('Week'), 'week')
                ->options(
                    WeeklyDevyStats::query()->get()->pluck('week', 'week')->toArray()
                ),

            SelectFilter::make(__('Pos'), 'devyPlayer.position')
                ->options([
                    'QB' => 'QB',
                    'RB' => 'RB',
                    'WR' => 'WR',
                    'TE' => 'TE'
                ])
        ];
    }

    protected function actions(): array
    {
        return [
        ];
    }
}