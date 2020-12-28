<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhpFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('php_functions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id')->comment('分类 ID');
            $table->string('name')->comment('函数名');
            $table->string('intro')->comment('简介、一句话介绍');
            $table->string('url')->comment('对应 php.net 网址');
            $table->text('example')->comment('举例');
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
        Schema::dropIfExists('php_functions');
    }
}
