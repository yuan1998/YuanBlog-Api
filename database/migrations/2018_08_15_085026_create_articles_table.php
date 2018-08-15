<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('description')->comment('描述');
            $table->string('excerpt')->comment('摘要');
            $table->unsignedInteger('user_id')->comment('发表文章用户Id');
            $table->text('body')->comment('内容本体');
            $table->unsignedInteger('read_count')->default(0)->comment('文章查看次数');
            $table->unsignedInteger('like_count')->default(0)->comment('用户点赞次数');
            $table->unsignedInteger('reply_count')->default(0)->comment('回复数量');
            $table->unsignedInteger('category_id')->comment('文章所属分类ID');
            $table->integer('article_status')->default(0)->comment('文章状态');
            $table->string('slug_title')->comment('SEO标题');
            $table->string('cover')->comment('文章封面');
            $table->json('cover_other')->comment('文章封面其他内容');
            $table->json('other')->nullable()->comment('其他配置');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categorys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
