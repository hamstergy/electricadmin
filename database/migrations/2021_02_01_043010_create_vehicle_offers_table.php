<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id');
            $table->string('type');
            $table->string('displayType');
            $table->dateTime('end_date');
            $table->string('disclaimers');
            $table->string('offer_data');
            $table->timestamps();
        });

        Schema::table('vehicle_offers', function($table) {
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_offers');
    }
}
