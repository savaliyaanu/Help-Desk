<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_year', function (Blueprint $table) {
            $table->bigIncrements('financial_id');
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();
            $table->enum('is_active',['Y','N'])->default('N');
            $table->enum('is_delete',['Y','N'])->default('N');
            $table->enum('is_data',['Y','N'])->default('N');
            $table->string('action_caption')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->string('fyear')->nullable();
            $table->string('year_heading')->nullable();
            $table->string('created_id')->nullable();
            $table->string('updated_id')->nullable();
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
        Schema::dropIfExists('financial_year');
    }
}
