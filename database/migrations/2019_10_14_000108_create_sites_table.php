<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('domain');
            $table->boolean('online')->default(0)->comment('是否在线');
            $table->unsignedBigInteger('seo')->comment('百度收录量');
            $table->string('get_type')->comment('爬虫或者 API');
            $table->string('date_xpath')->comment('最新日期的 xpath');
            $table->string('date_format')->comment('最新日期的格式');
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
        Schema::dropIfExists('sites');
    }
}
