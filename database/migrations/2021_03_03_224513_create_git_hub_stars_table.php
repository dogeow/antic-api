<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGitHubStarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_stars', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('owner/repo');
            $table->unsignedInteger('major')->comment('主版本号')->nullable();
            $table->unsignedInteger('minor')->comment('次版本号')->nullable();
            $table->unsignedInteger('patch')->comment('修订号')->nullable();
            $table->boolean('updated')->comment('是否已更新')->default(0);
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
        Schema::dropIfExists('git_hub_stars');
    }
}
