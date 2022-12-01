<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('things', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名称');
            $table->text('description')->nullable()->comment('详情');
            $table->unsignedInteger('amount')->default(1)->comment('数量');
            $table->unsignedDecimal('money')->nullable()->comment('单价');
            $table->unsignedBigInteger('place_id')->nullable()->comment('放置地点');
            $table->date('bought_at')->nullable()->comment('购买日期');
            $table->date('expired_at')->nullable()->comment('过期日期');
            $table->boolean('is_expiration_reminder')->unsigned()->nullable()->default(0)->comment('过期是否提醒');
            $table->timestamps();

            $table->comment('物品');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('things');
    }
};
