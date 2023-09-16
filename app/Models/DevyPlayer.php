<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DevyPlayer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'draft_year', 'position', 'team'];

    public function leagueTeam (): BelongsTo
    {
        return $this->belongsTo(LeagueTeam::class);
    }

    public function weeklyDevyStats(): HasMany
    {
        return $this->hasMany(WeeklyDevyStats::class);
    }
}
