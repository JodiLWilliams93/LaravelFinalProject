<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClimbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('climbs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name', 255);
            $table->string('rating', 25);
            $table->text('description');
            $table->integer('length')->nullable();
            $table->enum('type', ['Trad', 'Sport', 'Top Rope', 'Boulder']);
            $table->text('gear_needed')->nullable();
            $table->string('location', 255);
            $table->string( 'added_by', 255);
            $table->tinyInteger('public');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('climbs');
    }
}
