<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceStationMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_station_master', function (Blueprint $table) {
            $table->bigIncrements('station_id');
            $table->string('station_name')->nullable();
            $table->string('station_address')->nullable();
            $table->integer('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_person_name')->nullable();
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
        Schema::dropIfExists('service_station_master');
    }
}
