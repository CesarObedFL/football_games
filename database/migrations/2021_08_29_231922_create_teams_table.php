<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            
            $table->unsignedTinyInteger('position');
            $table->unsignedTinyInteger('wonMatches');
            $table->unsignedTinyInteger('drawedMatches');
            $table->unsignedTinyInteger('lostMatches');
            $table->unsignedInteger('scoredGoals');
            $table->unsignedInteger('allowedGoals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
