<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneratorTestingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generator_testing', function (Blueprint $table) {
            $table->bigIncrements('generator_testing_id');
            $table->unsignedBigInteger('challan_testing_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('ac_voltage')->nullable();
            $table->string('watts')->nullable();
            $table->string('dc_voltage_nl')->nullable();
            $table->string('dc_voltage_fl')->nullable();
            $table->string('dc_amp_nl')->nullable();
            $table->string('dc_amp_fl')->nullable();
            $table->string('rpm_nl')->nullable();
            $table->string('rpm_fl')->nullable();
            $table->string('ac_voltage_ifl')->nullable();
            $table->string('ac_voltage_pf')->nullable();
            $table->string('ac_voltage_rfl')->nullable();
            $table->string('ac_voltage_pfl')->nullable();
            $table->string('ac_amp_ol')->nullable();
            $table->string('ac_amp_pfl')->nullable();
            $table->string('watts_rfl')->nullable();
            $table->string('vr_ifl')->nullable();
            $table->string('rfl')->nullable();
            $table->string('kbl')->nullable();
            $table->string('amount_temp')->nullable();
            $table->string('regi')->nullable();
            $table->string('stator_main_winding')->nullable();
            $table->string('stator_aux_winding')->nullable();
            $table->string('ex_fld_wnd_regi')->nullable();
            $table->string('ex_arm_wnd_regi')->nullable();
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
        Schema::dropIfExists('generator_testing');
    }
}
