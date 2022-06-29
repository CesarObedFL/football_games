<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    /**
     * amount = unsignedDecimal(10, 2)
     * possibleProfit = unsignedDecimal(10, 2)
     * profit = unsignedDecimal(10, 2)
     * momio = smallInteger
     * timestamps = date
     * type = enum(['single', 'parlay'])
     * betsNumber = unsignedSmallInteger
     */
    protected $fillable = ['amount', 'possibleProfit', 'profit', 'momio', 'type', 'betsNumber'];
}
