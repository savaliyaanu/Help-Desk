<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complain', function (Blueprint $table) {
            $table->bigIncrements('complain_id');
            $table->string('complain_type')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->bigInteger('complain_no')->nullable();
            $table->bigInteger('distributor_id')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->enum('complain_status',['Pending','Resolved'])->nullable()->default('Pending');
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->string('client_name')->nullable();
            $table->string('address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('email_address')->nullable();
            $table->string('city_id')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('problem')->nullable();
            $table->string('solution')->nullable();
            $table->string('solution_by')->nullable();
            $table->dateTime('resolve_date')->nullable();
            $table->bigInteger('assign_id')->nullable();
            $table->string('medium_id')->nullable();
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
        Schema::dropIfExists('complain');
    }
}
