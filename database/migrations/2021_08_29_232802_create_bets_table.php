<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal('amount', 10, 2);
            $table->unsignedDecimal('possibleProfit', 10, 2);
            $table->unsignedDecimal('profit', 10, 2);
            $table->smallInteger('momio');
            $table->date('date'); // date
            $table->enum('type', ['single', 'parlay']);
            $table->unsignedSmallInteger('betsNumber'); // number of bets
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bets');
    }
}
