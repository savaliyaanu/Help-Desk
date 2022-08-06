<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorewellTestingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borewell_testing', function (Blueprint $table) {
            $table->bigIncrements('borewell_testing_id');
            $table->unsignedBigInteger('challan_testing_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->double('voltage1')->nullable();
            $table->double('voltage2')->nullable();
            $table->double('voltage3')->nullable();
            $table->double('nl_amp1')->nullable();
            $table->double('nl_amp2')->nullable();
            $table->double('nl_amp3')->nullable();
            $table->double('max_amp1')->nullable();
            $table->double('max_amp2')->nullable();
            $table->double('max_amp3')->nullable();
            $table->double('hz1')->nullable();
            $table->double('hz2')->nullable();
            $table->double('hz3')->nullable();
            $table->double('pf1')->nullable();
            $table->double('pf2')->nullable();
            $table->double('pf3')->nullable();
            $table->double('kw1')->nullable();
            $table->double('kw2')->nullable();
            $table->double('kw3')->nullable();
            $table->double('dp_amp1')->nullable();
            $table->double('dp_amp2')->nullable();
            $table->double('dp_amp3')->nullable();
            $table->double('so_head1')->nullable();
            $table->double('so_head2')->nullable();
            $table->double('so_head3')->nullable();
            $table->double('dp_head1')->nullable();
            $table->double('dp_head2')->nullable();
            $table->double('dp_head3')->nullable();
            $table->double('disch1')->nullable();
            $table->double('disch2')->nullable();
            $table->double('disch3')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('borewell_testing');
    }
}
