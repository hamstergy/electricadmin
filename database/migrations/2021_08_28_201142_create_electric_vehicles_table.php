<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectricVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electric_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('imageSlug')->nullable();
            $table->string('make');
            $table->string('model');
            $table->boolean('isConcept')->default(false);
            $table->string('releaseDate')->nullable();
            $table->float('acceleration', 3, 1)->nullable();
            $table->integer('speed')->nullable();
            $table->integer('range')->nullable();
            $table->integer('efficiency')->nullable();
            $table->integer('chargeSpeed')->nullable();
            $table->integer('battery')->nullable();
            $table->integer('price')->nullable();
            $table->string('drive')->nullable();
            $table->string('type')->nullable();
            $table->string('segment')->nullable();
            $table->integer('seats')->nullable();
            $table->longText('description')->nullable();
            $table->string('youtube')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('electric_vehicles');
    }
}
