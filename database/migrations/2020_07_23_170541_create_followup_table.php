<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followup', function (Blueprint $table) {
            $table->bigIncrements('followup_id');
            $table->string('complain_id')->nullable();
            $table->string('remark')->nullable();
            $table->string('next_followup_date')->nullable();
            $table->string('created_id')->nullable();
            $table->string('updated_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('financial_id')->nullable();
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
        Schema::dropIfExists('followup');
    }
}
