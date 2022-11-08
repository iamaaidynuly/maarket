<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopRequestProductFilterRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_request_product_filter_relations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shop_request_product_id');
            $table->bigInteger('filter_item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_request_product_filter_relations');
    }
}
