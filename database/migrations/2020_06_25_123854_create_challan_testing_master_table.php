<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallanTestingMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challan_testing_master', function (Blueprint $table) {
            $table->bigIncrements('challan_testing_id');
            $table->unsignedBigInteger('challan_id')->nullable();
            $table->unsignedBigInteger('challan_product_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->date('checking_date')->nullable();
            $table->string('testing_by')->nullable();
            $table->integer('sr_no')->nullable();
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
        Schema::dropIfExists('challan_testing_master');
    }
}
