<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainMediumDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complain_medium_details', function (Blueprint $table) {
            $table->bigIncrements('cmd_id');
            $table->bigInteger('complain_id')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('email')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('staff_name')->nullable();
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
        Schema::dropIfExists('complain_medium_details');
    }
}
