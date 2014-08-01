<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mrh_article', function(Blueprint $table)
		{
			$table->increments('art_id');
			$table->string('art_cat_id'); 		# 文章分类
			$table->string('art_text'); 		# 文章标题
			$table->string('art_alias'); 		# 文章别名
			$table->text('art_fulltext'); 		# 文章内容
			$table->string('art_introtext'); 	# 文章摘要
			$table->text('art_images'); 		# 文章索引小图
			$table->integer('art_created'); 	# 创建人
			$table->string('art_created_alias'); # 创建人别名
			$table->integer('art_modified');	# 创建时间
			$table->integer('art_checked');		# 更新人
			$table->integer('art_publish');		# 更新时间
			$table->text('art_metadata');		# seo信息
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('mrh_article');
	}

}
