<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNoteItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_note_item', function (Blueprint $table) {
            $table->bigIncrements('credit_note_item_id');
            $table->unsignedBigInteger('credit_note_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('challan_product_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->integer('amount')->nullable();
            $table->enum('type',['product','spare'])->nullable();
            $table->integer('created_id')->nullable();
            $table->integer('updates_id')->nullable();
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
        Schema::dropIfExists('credit_note_item');
    }
}
