<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplacementTravelingExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replacement_traveling_expense', function (Blueprint $table) {
            $table->bigIncrements('traveling_expense_id');
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->date('travel_date')->nullable();
            $table->string('time_from')->nullable();
            $table->string('time_to')->nullable();
            $table->string('traveling_detail')->nullable();
            $table->string('place')->nullable();
            $table->string('hault')->nullable();
            $table->string('journey')->nullable();
            $table->integer('amount')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->enum('is_delete',['N','Y'])->default('N');
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
        Schema::dropIfExists('replacement_traveling_expense');
    }
}
