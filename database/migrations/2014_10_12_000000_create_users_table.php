<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedInteger('rate_limit')->default(20);
            $table->unsignedTinyInteger('level')->comment('等级')->default(1);
            $table->unsignedTinyInteger('copper')->comment('铜币');
            $table->unsignedTinyInteger('silver')->comment('银币');
            $table->unsignedSmallInteger('gold')->comment('金币');
            $table->unsignedBigInteger('exp')->comment('经验值');
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
        Schema::dropIfExists('users');
    }
}
