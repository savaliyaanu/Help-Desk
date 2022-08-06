<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_master', function (Blueprint $table) {
            $table->bigIncrements('branch_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('state_id')->nullable();
            $table->string('pincode')->nullable();
            $table->string('gst_no')->nullable();
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->index('branch_id')->nullable();
            $table->index('company_id')->nullable();
            $table->foreign('company_id')->references('company_id')->on('company_master');
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
        Schema::dropIfExists('branch_master');
    }
}
