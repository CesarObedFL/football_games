<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $table = 'bets';

    protected $fillable = ['ticket_id', 'match_id'];

    public $timestamps = false;
    
}
