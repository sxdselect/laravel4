<?php

class HelperController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function breadcrumb()
	{
		# 面包屑
		$aValue = array('Home' => '/', 'Page' => '/page');

		echo breadcrumb($aValue);
	}


}
