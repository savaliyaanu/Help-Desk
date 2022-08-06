<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_master', function (Blueprint $table) {
            $table->bigIncrements('company_id');
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('state_id')->nullable();
            $table->text('phone')->nullable();
            $table->string('pincode')->nullable();
            $table->string('email')->nullable();
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->index('company_id')->nullable();
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
        Schema::dropIfExists('company_master');
    }
}
