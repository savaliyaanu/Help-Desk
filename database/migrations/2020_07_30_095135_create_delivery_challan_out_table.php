<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryChallanOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_challan_out', function (Blueprint $table) {
            $table->bigIncrements('delivery_challan_out_id');
            $table->unsignedBigInteger('challan_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->enum('status',['pending','inward'])->default('pending');
            $table->integer('branch_id')->nullable();
            $table->string('transport_vehicle')->nullable();
            $table->string('destination')->nullable();
            $table->string('despatched_through')->nullable();
            $table->integer('delivery_challan_no')->nullable();
            $table->integer('lr_no')->nullable();
            $table->integer('financial_id')->nullable();
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
        Schema::dropIfExists('delivery_challan_out');
    }
}
