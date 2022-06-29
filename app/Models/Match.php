<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class match extends Model
{
    use HasFactory;

    protected $table = 'matches';

    /**
     * league_id = id from leagues table
     * localTeam = string(50)
     * awayTeam = string(50)
     * selectedTeam = enum(['local', 'visit'])
     * timestamps = day and match schedule
     * score = char(7)
     * sofascore = unsignedDecimal(2, 2)
     * bettingClosed = enum(['W', 'D', 'L'])
     * foreBet = enum(['W', 'D', 'L'])
     * footballPredictions = enum(['W', 'D', 'L'])
     */
    protected $fillable = ['competition_id', 'localTeam', 'awayTeam', 'selectedTeam', 'score', 'sofascore', 'bettingClosed', 'foreBet', 'footballPredictions'];

}
