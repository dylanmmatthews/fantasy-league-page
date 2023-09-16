<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyDevyStats extends Model
{
    use HasFactory;
    /**
     * table
     *
     * @var string
     */
    protected $table = 'weekly_devy_stats';

    protected $guarded = ['id'];

    protected $attributes = [
        'year' => 2023,
        'opponent' => 'coming soon'
    ];

    public function devyPlayer(): BelongsTo
    {
        return $this->belongsTo(DevyPlayer::class);
    }

    public function getPositionalStats(string $position): array
    {
        switch ($position) {
            case 'QB':
                return collect([
                    "pass_att" => $this->passing_completion_attempts,
                    "pass_yards" => $this->passing_yards,
                    "pass_td" => $this->passing_touchdowns,
                    "pass_avg" => $this->passing_average,
                    "pass_qbr" => $this->passing_qbr,
                    "rush_att" => $this->rushing_carries,
                    "rush_yrds" => $this->rushing_yards,
                    "rush_td" => $this->rushing_touchdowns,
                    "rush_avg" => $this->rushing_average,
                    "rush_long" => $this->rushing_long,
                ])->filter(function ($value) {
                    return (float)$value !== 0.0;
                })->toArray();
            case 'RB':
            case 'WR':
            case 'TE':
            default:
                return collect([
                    "rush_att" => $this->rushing_carries,
                    "rush_yrds" => $this->rushing_yards,
                    "rush_td" => $this->rushing_touchdowns,
                    "rush_avg" => $this->rushing_average,
                    "rush_long" => $this->rushing_long,
                    "rec" => $this->receiving_catches,
                    "rec_yards" => $this->receiving_yards,
                    "rec_td" => $this->receiving_touchdowns,
                    "rec_avg" => $this->receiving_average,
                    "rec_long" => $this->receiving_long,
                    "kr_att" => $this->kick_returns_attempts,
                    "kr_yards" => $this->kick_returns_yards,
                    "kr_long" => $this->kick_returns_long,
                    "kr_td" => $this->kick_returns_touchdowns,
                    "kr_avg" => $this->kick_returns_average,
                    "pr_att" => $this->punt_returns_attempts,
                    "pr_yards" => $this->punt_returns_yards,
                    "pr_long" => $this->punt_returns_long,
                    "pr_td" => $this->punt_returns_touchdowns,
                    "pr_avg" => $this->punt_returns_average,
                ])->filter(function ($value) {
                    return (float)$value !== 0.0;
                })->toArray();
        }
    }
}