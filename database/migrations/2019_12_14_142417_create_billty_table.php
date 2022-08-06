<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBilltyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billty', function (Blueprint $table) {
            $table->bigIncrements('billty_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->bigInteger('billty_no')->nullable();
            $table->unsignedBigInteger('complain_id')->nullable();
            $table->string('challan_type')->nullable();
            $table->string('other')->nullable();
            $table->string('client_id')->nullable();
            $table->string('gst_no')->nullable();
            $table->dateTime('entry_date')->nullable();
            $table->string('transport_id')->nullable();
            $table->integer('freight_rs')->nullable();
            $table->enum('freight_rs_by', ['Company', 'Party'])->nullable();
            $table->integer('lr_no')->nullable();
            $table->dateTime('lr_date')->nullable();
            $table->string('entry_by')->nullable();
            $table->string('remark')->nullable();
            $table->dateTime('handover_date')->nullable();
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
        Schema::dropIfExists('billty');
    }
}
