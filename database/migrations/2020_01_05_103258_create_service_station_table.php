<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_station', function (Blueprint $table) {
            $table->bigIncrements('service_id');
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('service_station_name')->nullable();
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->index('company_id')->nullable();
            $table->index('branch_id')->nullable();
            $table->foreign('company_id')->references('company_id')->on('company_master');
            $table->foreign('branch_id')->references('branch_id')->on('branch_master');
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
        Schema::dropIfExists('service_station');
    }
}
