<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_make_id');
            $table->string('name');
            $table->string('slug');
            $table->string('class');
            $table->string('description');
            $table->string('detail');
            $table->integer('price');
            $table->integer('lease');
            $table->integer('finance');
            $table->string('image');
            $table->string('video');
            $table->timestamps();
        });

        Schema::table('vehicle_models', function($table) {
            $table->foreign('vehicle_make_id')->references('id')->on('vehicle_makes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_models');
    }
}
