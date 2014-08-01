<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface 
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mrh_user';

	/**
	 * The database table primary key
	 *
	 * @var string
	 */
	protected $primaryKey = 'usr_id';

	/**
	 * 数据可以修改字段
	 *
	 * @var string
	 */
	protected $fillable = array(
		'usr_password', 'usr_username', 'usr_nickname', 'usr_email', 'usr_token', 'usr_status', 'remember_token'
	);

	/**
	 * 数据不可修改字段
	 *
	 * @var string
	 */
	protected $guarded = array('usr_id');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->usr_password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->usr_email;
	}

}
