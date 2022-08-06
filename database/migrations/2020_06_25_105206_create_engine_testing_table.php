<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngineTestingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engine_testing', function (Blueprint $table) {
            $table->bigIncrements('testing_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('challan_testing_id')->nullable();
            $table->integer('reading')->nullable();
            $table->integer('sfc')->nullable();
            $table->integer('temp_rpm')->nullable();
            $table->integer('temp_percentage')->nullable();
            $table->integer('perm_rpm')->nullable();
            $table->integer('perm_percentage')->nullable();
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
        Schema::dropIfExists('engine_testing');
    }
}
