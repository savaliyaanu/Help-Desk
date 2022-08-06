<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complain_item_details', function (Blueprint $table) {
            $table->bigIncrements('cid_id');
            $table->bigInteger('complain_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('complain')->nullable();
            $table->string('application')->nullable();
            $table->enum('warranty', ['No', 'Yes'])->nullable();
            $table->string('solution')->nullable();
            $table->integer('production_no')->nullable();
            $table->integer('invoice_no')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('solution_by')->nullable();
            $table->integer('created_id')->nullable();
            $table->integer('updated_id')->nullable();
            $table->enum('is_delete', ['N', 'Y'])->nullable();
            $table->enum('is_product_used', ['N', 'Y'])->nullable();
            $table->enum('complain_status', ['Pending', 'Resolved'])->default('Pending');
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
        Schema::dropIfExists('complain_item_details');
    }
}
