<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectricBikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electric_bikes', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('imageSlug')->nullable();
            $table->string('make');
            $table->string('model');
            $table->integer('speed')->nullable();
            $table->integer('range')->nullable();
            $table->binary('description')->nullable();
            $table->string('youtube')->nullable();
            $table->float('price')->nullable();
            $table->integer('battery')->nullable();
            $table->integer('motor')->nullable();
            $table->string('gears')->nullable();
            $table->string('tire')->nullable();
            $table->string('type')->nullable();
            $table->integer('weight')->nullable();
            $table->boolean('folding')->nullable();
            $table->string('break_system')->nullable();
            $table->string('frame_type')->nullable();
            $table->string('url')->nullable();
            $table->string('amazon_id')->nullable();
            $table->integer('review_rate')->nullable();
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
        Schema::dropIfExists('electric_bikes');
    }
}
