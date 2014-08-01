<?php

class UserController extends \BaseController 
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// get all the data
		$aUsr = User::all();
		
		// load the view and pass the usrs
		return View::make('user.index')
			->with('aUsr', $aUsr);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('user.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$aRules = array(
			'name' => 'required',
			'email' => 'required|email',
			'nerd_level' => 'required|numeric'
		);
		$oValidator = Validator::make(Input::all(), $aRules);

		# process the login
		if ( $oValidator->fails() ) {
			return Redirect::to('user/create')
				->withErrors($oValidator)
				->withInput(Input::except('password'));
		}

		$oUsr = new User;
		foreach ($aRules as $key => $value) {
			$oUsr->$key = Input::get($key);
		}
		$oUsr->save();

		#redirect
		Session::flash('message', 'Successfully created user!');
		return Redirect::to('user');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// get the user
		$aUsr = User::find($id);

		# show the view and pass the user to it
		return View::make('user.show')
			->with('aUsr', $aUsr);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// get the nerd
		$aUsr = User::find($id);

		// show the edit form and pass the nerd
		return View::make('user.edit')
			->with('aUsr', $aUsr);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$aRules = array(
			'name'       => 'required',
			'email'      => 'required|email',
			'nerd_level' => 'required|numeric'
		);
		$oValidator = Validator::make(Input::all(), $aRules);

		// process the login
		if ($oValidator->fails()) {
			return Redirect::to('nerds/' . $id . '/edit')
				->withErrors($oValidator)
				->withInput(Input::except('password'));
		}

		// store
		$oUsr = User::find($id);
		$oUsr->name = Input::get('name');
		$oUsr->email = Input::get('email');
		$oUsr->save();

		// redirect
		Session::flash('message', 'Successfully updated User!');
		return Redirect::to('user');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
		$oUser = User::find($id);
		$oUser->delete();

		// redirect
		Session::flash('message', 'Successfully deleted the user!');
		return Redirect::to('user');
	}


	/**
	 * 登陆界面
	 *
	 * @return Response
	 */
	public function login()
	{
		var_dump( 11111 );exit;
		return View::make('user.login');
	}

	/**
	 * 处理登陆
	 *
	 * @return Response
	 */
	public function singn()
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$aRules = array(
			'username' => 'required', 'password' => 'required',
		);
		$oValidator = Validator::make(Input::all(), $aRules);

		if ( $oValidator->fails() ) {
			Redirect::to('user/login')
				->withErrors($oValidator)
				->withInput(Input::except('password'));
		}


	}
}
