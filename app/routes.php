<?php

/*
|--------------------------------------------------------------------------
| Application Routes
| 应用程序路由
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| 在这里你可以为应用程序注册所有的路由。
| It's a breeze. Simply tell Laravel the URIs it should respond to
| 这非常的容易。简单的告诉 Laravel 这些 URI 应该响应，
| and give it the Closure to execute when that URI is requested.
| 并且给它一个闭包，当那个URI发起请求后执行它。
|
*/

# 前台模块
Route::get('/',
	array(
		'as' => 'home', 
		'uses' => 'HomeController@showWelcome'
	)
);

# 登陆模块
Route::group(array('before' => 'guest'), function()
{
	# CSRF 验证用户输入
	Route::group(array('before' => 'csrf'), function()
	{
		# 提交登陆
		Route::post('sign-in-post', 
			array(
				'as' => 'sign-in-post',
				'uses' => 'AccountController@postSignIn'
			)
		);

		# 提交注册
		Route::post('sign-up-post',
			array(
				'as' => 'sign-up-post',
				'uses' => 'AccountController@postSignUp'
			)
		);

		# 提交忘记密码验证
		Route::post('forgot-password-post',
			array(
				'as' => 'forgot-password-post',
				'uses' => 'AccountController@postForgotPassword'
			)
		);
	});

	# 登陆界面
	Route::get('sign-in',
		array(
			'as' => 'sign-in',
			'uses' => 'AccountController@getSignIn'
		)
	);

	# 注册界面
	Route::get('sign-up',
		array(
			'as' => 'sign-up',
			'uses' => 'AccountController@getSignUp'
		)
	);

	# 验证注册界面
	Route::get('activate-account/{code}',
		array(
			'as' => 'activate-account',
			'uses' => 'AccountController@getActivateAccount'
		)
	);

	# 忘记密码界面
	Route::get('forgot-password',
		array(
			'as' => 'forgot-password',
			'uses' => 'AccountController@getForgotPassword'
		)
	);

	# 验证密码界面
	Route::get('forgot-password-activate/{user}/{code}',
		array(
			'as' => 'forgot-password-activate',
			'uses' => 'AccountController@getForgotPasswordActivate'
		)
	);

});

# 用户登陆操作模块
Route::group(array('before' => 'auth'), function()
{
	# CSRF 验证用户输入
	Route::group(array('before' => 'csrf'), function()
	{
		# 提交修改密码
		Route::post('change-password-post',
			array(
				'as' => 'change-password-post',
				'uses' => 'AccountController@postChangePassword'
			)
		);
	});

	# 修改密码界面
	Route::get('change-password',
		array(
			'as' => 'change-password',
			'uses' => 'AccountController@getChangePassword'
		)
	);

	# 登出
	Route::get('sign-out',
		array (
			'as' => 'sign-out',
			'uses' => 'AccountController@getSignOut'
		)
	);
});


# 系统模块
Route::group(array('before' => 'auth', 'prefix' => 'administrator'), function()
{
	
});

# 文章模块
Route::group(array('prefix' => 'article'), function()
{

});

# PHPExecl模块
Route::group(array('prefix' => 'execl'), function()
{
	# 读取Execl文件
	Route::get('reader/{filename}/{start?}', 
		array(
			'as' => 'PHPExecl Reader',
			'uses' => 'ExeclController@reader'
		)
	);

	# 写入Execl文件
	Route::get('writer', 
		array(
			'as' => 'PHPExecl Writer',
			'uses' => 'ExeclController@writer'
		)
	);
});

# Helper模块
Route::group(array('prefix' => 'helper'), function()
{
	# 面包屑函数
	Route::get('breadcrumb', 
		array(
			'as' => 'breadcrumb',
			'uses' => 'HelperController@breadcrumb'
		)
	);
});