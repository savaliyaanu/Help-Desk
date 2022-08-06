<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceReplacementInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_replacement_in', function (Blueprint $table) {
            $table->bigIncrements('replacement_in_id');
            $table->unsignedBigInteger('replacement_out_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('billty_no')->nullable();
            $table->date('inward_date')->nullable();
            $table->string('transport_id')->nullable();
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
        Schema::dropIfExists('advance_replacement_in');
    }
}
