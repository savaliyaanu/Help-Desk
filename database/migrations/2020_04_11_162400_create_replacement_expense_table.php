<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplacementExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replacement_expense', function (Blueprint $table) {
            $table->bigIncrements('expense_id');
            $table->unsignedBigInteger('complain_id')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->string('city_name')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('mechanic_id')->nullable();
            $table->integer('mechanic_id2')->nullable();
            $table->dateTime('traveling_from')->nullable();
            $table->dateTime('traveling_to')->nullable();
            $table->integer('ta_da_amount')->nullable();
            $table->integer('advance_amount')->nullable();
            $table->string('traveling_reason')->nullable();
            $table->integer('traveling_days')->nullable();
            $table->integer('amount_taken_from_dealer')->nullable();
            $table->integer('expense_amount')->nullable();
            $table->string('party_name')->nullable();
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('reason_for_callback')->nullable();
            $table->string('remark')->nullable();
            $table->enum('status',['solve','send to service station'])->default('solve');
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
        Schema::dropIfExists('replacement_expense');
    }
}
