<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryChallanOutProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_challan_out_product', function (Blueprint $table) {
            $table->bigIncrements('delivery_challan_product_id');
            $table->unsignedBigInteger('delivery_challan_out_id')->nullable();
            $table->unsignedBigInteger('challan_product_id')->nullable();
            $table->enum('is_inward',['Y','N'])->default('N');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
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
        Schema::dropIfExists('delivery_challan_out_product');
    }
}
