<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceReplacementOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_replacement_out', function (Blueprint $table) {
            $table->bigIncrements('replacement_out_id');
            $table->unsignedBigInteger('complain_id')->nullable();
            $table->string('product_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->string('financial_year')->nullable();
            $table->integer('billty_no')->nullable();
            $table->string('company_name')->nullable();
            $table->string('order_id')->nullable();
            $table->string('transport_id')->nullable();
            $table->string('lr_no')->nullable();
            $table->string('lory_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->enum('status',['pending','receive'])->default('pending');
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
        Schema::dropIfExists('advance_replacement_out');
    }
}
