<?php

class AccountController extends \BaseController 
{

	/**
	 * 登陆界面
	 *
	 * @return Response
	 */
	public function getSignIn()
	{
		return View::make('account/signin');
	}


	/**
	 * 提交登陆界面
	 *
	 * @return Response
	 */
	public function postSignIn()
	{
		$aRules = array(
			'usr_email' => 'required|email', 'usr_password' => 'required'
		);
		$oValid = Validator::make(Input::all(), $aRules);

		# 验证是否通过
		if ( $oValid->fails() ) {
			return Redirect::route('sign-in')->withInput()->with('error', 'invalid-account');
		}

		# 查找用户
		$oUsr = User::where('usr_email', '=', Input::get('usr_email'));

		#　验证用户是否存在
		if ( !$oUsr->count() ) {
			return Redirect::route('sign-in')->withInput()->with('error', 'account-doesnt-exist');
		}

		# 验证密码
		$oUsr = $oUsr->first();
		if ( !Hash::check(Input::get('usr_password'), $oUsr->usr_password) ) {
			# 验证密码失败
			return Redirect::route('sign-in')->withInput()->with('error', 'invalid-account');
		}

		# 验证用户状态
		if ( $oUsr->usr_status != 1 ) {
			return Redirect::route('sign-in')->withInput()->with('error', 'inactive-account');
		}

		# 登录系统
		Auth::login($oUsr);
		return Redirect::intended('/');
	}


	/**
	 * 注册界面
	 *
	 * @return Response
	 */
	public function getSignUp()
	{
		return View::make('account/signup');
	}


	/**
	 * 提交注册界面
	 *
	 * @return Response
	 */
	public function postSignUp()
	{
		$aRules = array(
			'usr_email' => 'required|max:50|email|unique:mrh_user',
			'usr_username' => 'required|max:50',
			'usr_password' => 'required|min:5',
			'usr_password_again' => 'required|same:usr_password',
		);
		$oValid = Validator::make(Input::all(), $aRules);

		# 验证用户输入是否通过
		if ( $oValid->fails() ) {
			return Redirect::route('sign-up')->withErrors($oValid)->withInput();
		}

		# 表单数据
		$sCode = str_random(60);
		$sEmail = Input::get('usr_email');
		$sUsername = Input::get('usr_username');
		$sPassword = Input::get('usr_username');
		$oUsr = User::find(1);
		
		#　组装数据
		$aUsrValue = array(
			'usr_email' => $sEmail,
			'usr_status' => 0,
			'usr_username' => $sUsername,
			'usr_nickname' => $sUsername,
			'usr_password' => Hash::make($sPassword),
			'remember_token' => $sCode,
		);
		$oUsr = User::create($aUsrValue);
		
		# 验证是否插入数据库
		if ( $oUsr ) 
		{
			# 发送验证邮件
			$aValue = array('name' => $sUsername, 'link' => URL::route('activate-account', $sCode));
			$oEmail = Mail::send('emails.activate', $aValue, function($oMessage) use ($oUsr) 
			{
				$oMessage->from(Input::get('usr_email'), Input::get('usr_username'));
				$oMessage->to($oUsr->usr_email, $oUsr->usr_username)->subject('Activate your account');
			});

			if ( $oEmail ) {
				return Redirect::route('sign-up')->with('success', true);
			}
		}
		return Redirect::route('sign-up')->with('unex-error', true)->withInput();
	}


	/**
	 * 验证邮箱注册界面
	 *
	 * @return Response
	 */
	public function getActivateAccount($sCode)
	{
		$oUsr = User::where('remember_token', '=', $sCode)->where('usr_status', '=', 0);

		# 验证
		if ( $oUsr->count() ) 
		{
			$oUsr = $oUsr->first();
			$oUsr->usr_status = 1;
			$oUsr->remember_token = '';

			# 注册用户验证邮箱成功
			if ( $oUsr->save() ) {
				return Redirect::route('sign-in')->with('success', true);
			}
			return Redirect::route('sign-in')->with('error', 'unactive-account');
		}
		# 没有需要验证注册邮箱
		return App::abort(404);
	}


	/**
	 * 忘记密码界面
	 *
	 * @return Response
	 */
	public function getForgotPassword()
	{
		return View::make('account/forgotpassword');
	}


	/**
	 * 提交忘记密码验证
	 *
	 * @return Response
	 */
	public function postForgotPassword()
	{

	}


	/**
	 * 忘记密码界面
	 *
	 * @return Response
	 */
	public function getForgotPasswordActivate()
	{
		//
	}


	/**
	 * 修改密码界面
	 *
	 * @return Response
	 */
	public function getChangePassword()
	{
		//
	}


	/**
	 * 提交修改密码界面
	 *
	 * @return Response
	 */
	public function postChangePassword()
	{
		//
	}


	/**
	 * 登出界面
	 *
	 * @return Response
	 */
	public function getSignOut()
	{
		Auth::logout();
		return Redirect::route('home');
	}

}
