<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpareInspectionReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_inspection_report', function (Blueprint $table) {
            $table->bigIncrements('spare_inspection_id');
            $table->unsignedBigInteger('challan_optional_id')->nullable();
            $table->unsignedBigInteger('inspection_report_id')->nullable();
            $table->unsignedBigInteger('challan_product_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('complain')->nullable();
            $table->string('company_observation')->nullable();
            $table->string('part_change')->nullable();
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->integer('branch_id')->nullable();
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
        Schema::dropIfExists('spare_inspection_report');
    }
}
