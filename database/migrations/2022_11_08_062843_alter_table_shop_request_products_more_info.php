<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableShopRequestProductsMoreInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_request_products', function (Blueprint $table) {
            $table->dropColumn('product_id');
            $table->bigInteger('title')->after('shop_id');
            $table->bigInteger('description')->after('title');
            $table->bigInteger('price')->after('description');
            $table->bigInteger('sale')->after('price');
            $table->bigInteger('current_price')->after('sale');
            $table->bigInteger('brand_id')->after('current_price');
            $table->bigInteger('brand_items_id')->after('brand_id');
            $table->bigInteger('country_id')->after('brand_items_id');
            $table->string('slug')->after('country_id');
            $table->boolean('best')->default(false)->after('slug');
            $table->boolean('new')->default(true)->after('best');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
