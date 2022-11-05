<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('title')->nullable();
            $table->string('artikul')->nullable();
            $table->integer('short_description')->nullable();
            $table->integer('description')->nullable();
            $table->integer('specifications')->nullable();
            $table->integer('price')->nullable();
            $table->integer('sale')->nullable();
            $table->integer('current_price')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('stock');
            $table->string('category_id');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('slug');
            $table->integer('best')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
