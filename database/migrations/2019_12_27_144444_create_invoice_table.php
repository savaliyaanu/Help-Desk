<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->bigIncrements('invoice_id');
            $table->unsignedBigInteger('challan_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->date('invoice_date')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->enum('view_accessories', ['N', 'Y'])->nullable()->default('N');
            $table->string('transport_id')->nullable();
            $table->string('lr_no')->nullable();
            $table->dateTime('lr_date')->nullable();
            $table->string('lory_no')->nullable();
            $table->string('authorize_person')->nullable();
            $table->string('remark')->nullable();
            $table->enum('change_develiry_address', ['N', 'Y'])->nullable()->default('N');
            $table->string('billing_name')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('city_id')->nullable();
            $table->string('pincode')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('contact_person')->nullable();
            $table->bigInteger('invoice_no')->nullable();
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
        Schema::dropIfExists('invoice');
    }
}
