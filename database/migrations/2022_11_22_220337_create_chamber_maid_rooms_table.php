<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChamberMaidRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamber_maid_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('start_time', 255);
            $table->string('end_time', 255);
            $table->string('turn', 255);
            $table->unsignedBigInteger('rooms_id');
            $table->unsignedBigInteger('users_id');
        });

        Schema::table('chamber_maid_rooms', function (Blueprint $table) {
            $table->foreign('rooms_id')->references('id')->on('rooms');
            $table->foreign('users_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chamber_maid_rooms');
    }
}
