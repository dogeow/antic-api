<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoonHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moon_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('moon_id');
            $table->unsignedTinyInteger('num1');
            $table->unsignedTinyInteger('num2');
            $table->unsignedTinyInteger('num3');
            $table->unsignedTinyInteger('num4');
            $table->unsignedTinyInteger('num5');
            $table->unsignedTinyInteger('num6');
            $table->string('name');
            $table->decimal('money', 4, 2)->default(0);
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
        Schema::dropIfExists('moon_histories');
    }
}
