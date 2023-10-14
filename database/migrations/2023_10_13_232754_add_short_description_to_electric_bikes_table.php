<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShortDescriptionToElectricBikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electric_bikes', function (Blueprint $table) {
            $table->string('short_description')->nullable();
            $table->binary('review')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('electric_bikes', function (Blueprint $table) {
            $table->dropColumn('short_description');
            $table->dropColumn('review');
        });
    }
}