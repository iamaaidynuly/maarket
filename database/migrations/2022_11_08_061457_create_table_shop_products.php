<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableShopProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('shop_id');
            $table->dropColumn('status');
        });

        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shop_id');
            $table->bigInteger('product_id');
            $table->bigInteger('price');
            $table->boolean('available')->default(false);
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
        Schema::dropIfExists('table_shop_products');
    }
}
