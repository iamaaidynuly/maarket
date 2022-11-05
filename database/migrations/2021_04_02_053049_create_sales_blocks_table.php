<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('title')->nullable();
            $table->integer('content')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sales_blocks');
    }
}
