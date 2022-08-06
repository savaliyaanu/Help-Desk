<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeldingGeneratorTestingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('welding_generator_testing', function (Blueprint $table) {
            $table->bigIncrements('welding_generator_testing_id');
            $table->unsignedBigInteger('challan_testing_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->double('voltage_low')->nullable();
            $table->double('voltage_high')->nullable();
            $table->double('voltage_lighting')->nullable();
            $table->double('temperature')->nullable();
            $table->double('no_load1')->nullable();
            $table->double('no_load2')->nullable();
            $table->double('no_load3')->nullable();
            $table->double('no_load4')->nullable();
            $table->double('no_load5')->nullable();
            $table->double('no_load6')->nullable();
            $table->double('no_load7')->nullable();
            $table->double('resistive_load1')->nullable();
            $table->double('resistive_load2')->nullable();
            $table->double('resistive_load3')->nullable();
            $table->double('resistive_load4')->nullable();
            $table->double('resistive_load5')->nullable();
            $table->double('resistive_load6')->nullable();
            $table->double('resistive_load7')->nullable();
            $table->double('welding_low1')->nullable();
            $table->double('welding_low2')->nullable();
            $table->double('welding_low3')->nullable();
            $table->double('welding_low4')->nullable();
            $table->double('welding_low5')->nullable();
            $table->double('welding_low6')->nullable();
            $table->double('welding_low7')->nullable();
            $table->double('welding_high1')->nullable();
            $table->double('welding_high2')->nullable();
            $table->double('welding_high3')->nullable();
            $table->double('welding_high4')->nullable();
            $table->double('welding_high5')->nullable();
            $table->double('welding_high6')->nullable();
            $table->double('welding_high7')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
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
        Schema::dropIfExists('welding_generator_testing');
    }
}
