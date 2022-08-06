<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallanItemMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challan_item_master', function (Blueprint $table) {
            $table->bigIncrements('challan_product_id');
            $table->unsignedBigInteger('challan_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('packing_type')->nullable();
            $table->enum('warranty',['N','Y'])->nullable();
            $table->string('serial_no')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('production_no')->nullable();
            $table->date('bill_date')->nullable();
            $table->string('application')->nullable();
            $table->string('hour_run')->nullable();
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->enum('is_used',['N','Y'])->nullable()->default('N');
            $table->enum('is_main',['N','Y'])->nullable()->default('Y');
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
        Schema::dropIfExists('challan_item_master');
    }
}
