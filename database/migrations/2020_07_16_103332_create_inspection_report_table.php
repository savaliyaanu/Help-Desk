<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_report', function (Blueprint $table) {
            $table->bigIncrements('inspection_report_id');
            $table->unsignedBigInteger('challan_id')->nullable();
            $table->unsignedBigInteger('challan_product_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('mechanic_name')->nullable();
            $table->string('problem')->nullable();
            $table->string('crank_shaft1')->nullable();
            $table->string('crank_shaft2')->nullable();
            $table->string('crank_shaft3')->nullable();
            $table->string('crank_shaft4')->nullable();
            $table->string('trb_bb1')->nullable();
            $table->string('trb_bb2')->nullable();
            $table->string('trb_bb3')->nullable();
            $table->string('cr_bearing1')->nullable();
            $table->string('cr_bearing2')->nullable();
            $table->string('cyl_liner1')->nullable();
            $table->string('cyl_liner2')->nullable();
            $table->string('piston1')->nullable();
            $table->string('piston2')->nullable();
            $table->string('piston3')->nullable();
            $table->string('gudgeon_pin1')->nullable();
            $table->string('gudgeon_pin2')->nullable();
            $table->string('gudgeon_pin3')->nullable();
            $table->string('gudgeon_pin4')->nullable();
            $table->string('ring_set1')->nullable();
            $table->string('ring_set2')->nullable();
            $table->string('ring_set3')->nullable();
            $table->string('con_rod1')->nullable();
            $table->string('con_rod2')->nullable();
            $table->string('con_rod3')->nullable();
            $table->string('con_rod4')->nullable();
            $table->string('cam_shaft1')->nullable();
            $table->string('cam_shaft2')->nullable();
            $table->string('cam_shaft3')->nullable();
            $table->string('cam_shaft4')->nullable();
            $table->string('valve1')->nullable();
            $table->string('valve2')->nullable();
            $table->string('valve3')->nullable();
            $table->string('valve4')->nullable();
            $table->string('ram_roller1')->nullable();
            $table->string('ram_roller2')->nullable();
            $table->string('ram_roller3')->nullable();
            $table->string('ram_roller4')->nullable();
            $table->string('cyl_head1')->nullable();
            $table->string('cyl_head2')->nullable();
            $table->string('cyl_head3')->nullable();
            $table->string('valve_guide1')->nullable();
            $table->string('valve_guide2')->nullable();
            $table->string('side_cover1')->nullable();
            $table->string('side_cover2')->nullable();
            $table->string('side_cover3')->nullable();
            $table->string('crank_case1')->nullable();
            $table->string('crank_case2')->nullable();
            $table->string('crank_case3')->nullable();
            $table->string('crank_case4')->nullable();
            $table->string('componentsA1')->nullable();
            $table->string('componentsA2')->nullable();
            $table->string('componentsA3')->nullable();
            $table->string('componentsA4')->nullable();
            $table->string('componentsA5')->nullable();
            $table->string('componentsB1')->nullable();
            $table->string('componentsB2')->nullable();
            $table->string('componentsB3')->nullable();
            $table->string('componentsB4')->nullable();
            $table->string('componentsB5')->nullable();
            $table->string('componentsC1')->nullable();
            $table->string('componentsC2')->nullable();
            $table->string('componentsC3')->nullable();
            $table->string('componentsC4')->nullable();
            $table->string('componentsC5')->nullable();
            $table->string('componentsD1')->nullable();
            $table->string('componentsD2')->nullable();
            $table->string('componentsD3')->nullable();
            $table->string('componentsD4')->nullable();
            $table->string('componentsD5')->nullable();
            $table->string('company_observation')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('fault')->nullable();
            $table->string('parts_replaced')->nullable();
            $table->string('external')->nullable();
            $table->string('internal')->nullable();
            $table->string('component_changed_fitted')->nullable();
            $table->string('financial_id')->nullable();
            $table->string('created_id')->nullable();
            $table->string('updated_id')->nullable();
            $table->string('complain')->nullable();
            $table->string('observation')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('change')->nullable();
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
        Schema::dropIfExists('inspection_report');
    }
}
