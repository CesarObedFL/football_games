<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';
    
    /**
     * name = string(50)
     * competition_id = id from leagues table
     * division = smallInteger
     * position = smallInteger
     */
    protected $fillable = ['name', 'competition_id', 'division', 'position'];

    public $timestamps = false;
}
