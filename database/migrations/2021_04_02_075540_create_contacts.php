<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('phone_number')->nullable();
            $table->string('email')->unique();
            $table->integer('address')->nullable();
            $table->integer('description')->nullable();
            $table->integer('title')->nullable();
            $table->string('whats_app')->nullable();
            $table->string('telegram')->nullable();
            $table->string('instagram')->nullable();
            $table->integer('meta_title')->nullable();
            $table->integer('meta_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contacts');
    }
}
