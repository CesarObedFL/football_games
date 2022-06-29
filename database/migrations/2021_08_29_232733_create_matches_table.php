<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('league_id')->constrained();
            $table->string('localTeam', 50);
            $table->string('awayTeam', 50);
            $table->enum('selectedTeam', ['local', 'visit']);
            $table->dateTime('schedule'); // date & hour
            $table->char('score', 7)->default(0);
            $table->unsignedDecimal('sofascore', 2, 2);
            $table->enum('bettingClosed', ['W', 'D', 'L']);
            $table->enum('foreBet', ['W', 'D', 'L']);
            $table->enum('footballPredictions', ['W', 'D', 'L']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
