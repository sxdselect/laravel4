<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('mrh_user')->insert(
			array(
				'usr_username' => 'admin',
				'usr_password' => Hash::make('admin'),
				'usr_nickname' => '管理员',
				'usr_email'  => '',
				'usr_status' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			)
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('mrh_user')->delete();
	}

}
