<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challan', function (Blueprint $table) {
            $table->bigIncrements('challan_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->bigInteger('challan_no')->nullable();
            $table->unsignedBigInteger('billty_id')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('city_id')->nullable();
            $table->string('pincode')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('other_shortage_item')->nullable();
            $table->string('contact_person')->nullable();
            $table->enum('change_bill_address',['N','Y'])->nullable();
            $table->enum('current_status',['Dispatch','Repairing'])->default('Repairing');
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->enum('is_completed',['Y','N'])->default('N');
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
        Schema::dropIfExists('challan');
    }
}
