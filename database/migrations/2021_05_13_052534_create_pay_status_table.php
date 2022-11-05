<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_status', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('order_id');
            $table->string('transaction_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('amount');
            $table->integer('commission');
            $table->integer('commission_included');
            $table->integer('attempt');
            $table->string('return_url')->nullable();
            $table->string('merchant_id')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('callback_url')->nullable();
            $table->date('date')->nullable();
            $table->date('date_out')->nullable();
            $table->integer('demo');
            $table->integer('status');
            $table->string('err_code')->nullable();
            $table->string('err_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pay_status');
    }
}


