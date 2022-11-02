<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id');
            $table->longText('description');
            $table->string('rating');
            $table->string('author')->nullable();
            $table->timestamps();
        });

        Schema::table('car_reviews', function($table) {
            $table->foreign('vehicles_id')->references('id')->on('electric_vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_reviews');
    }
}
