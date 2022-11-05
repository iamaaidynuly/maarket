<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table ){
            $table->enum('type', ['individual', 'entity'])->default('individual')->after('role');
            $table->string('bin')->nullable()->after('code_date');
            $table->string('entity_address')->nullable()->after('bin');
            $table->string('actual_address')->nullable()->after('bin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('users', ['type', 'bin', 'entity_address', 'actual_address']);
    }
}
