<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplacementOtherExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replacement_other_expense', function (Blueprint $table) {
            $table->bigIncrements('other_expense_id');
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->string('detail')->nullable();
            $table->integer('amount')->nullable();
            $table->enum('is_delete', ['N', 'Y'])->default('N');
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->integer('financial_id')->nullable();
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
        Schema::dropIfExists('replacement_other_expense');
    }
}
