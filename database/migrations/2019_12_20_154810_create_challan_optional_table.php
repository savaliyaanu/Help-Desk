<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallanOptionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challan_optional', function (Blueprint $table) {
            $table->bigIncrements('challan_optional_id');
            $table->unsignedBigInteger('challan_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('challan_product_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->enum('optional_status',['Add','Remove','Spare'])->nullable();
            $table->enum('is_used',['N','Y'])->nullable()->default('N');
            $table->string('qty')->nullable();
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
        Schema::dropIfExists('challan_optional');
    }
}
