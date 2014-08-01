<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mrh_user', function(Blueprint $table) {
			$table->increments('usr_id');
			$table->string('usr_username', 64);
			$table->string('usr_password', 64);
			$table->string('usr_nickname', 64)->default('');
			$table->string('usr_email', 100)->default('');
			$table->boolean('usr_status')->default(0);
			$table->string('remember_token', 100)->nullable();
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
		Schema::drop('mrh_user');
	}

}
