<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->string('name');
            $table->string('description');
            $table->string('address');
            $table->double('rating')->default(0);
            $table->string('city_id')->nullable();
            $table->string('icon')->nullable();
            $table->string('min_price')->nullable();
            $table->string('delivery')->nullable();
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
        Schema::dropIfExists('shops');
    }
}
