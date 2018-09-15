<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reply_id')->default(0)->comment('对应回复ID');
            $table->unsignedInteger('article_id')->comment('文章Id');
            $table->text('reply_content')->comment('回复内容');
            $table->string('reply_email')->comment('回复者邮箱');
            $table->string('reply_status')->comment('状态');
            $table->string('reply_name')->comment('回复者名称');
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
        Schema::dropIfExists('reply');
    }
}
