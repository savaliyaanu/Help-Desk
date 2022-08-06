<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallanShortageItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challan_shortage_item', function (Blueprint $table) {
            $table->bigIncrements('challan_shortage_item_id');
            $table->unsignedBigInteger('shortage_item_master_id')->nullable();
            $table->unsignedBigInteger('challan_id')->nullable();
            $table->unsignedBigInteger('challan_product_id')->nullable();
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
        Schema::dropIfExists('challan_shortage_item');
    }
}
