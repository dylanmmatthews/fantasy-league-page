<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * LeagueTeam
 */
class LeagueTeam extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    /**
     * table
     *
     * @var string
     */
    protected $table = 'league_teams';
    
    /**
     * devyPlayer relationship
     *
     * @return HasMany
     */
    public function devyPlayer(): HasMany
    {
        return $this->hasMany(DevyPlayer::class);
    }
}