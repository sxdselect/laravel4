<?php

if ( !function_exists('breadcrumb')) 
{
	/**
	 * 面包屑
	 *
	 * @return Response
	 */
	function breadcrumb($aValue)
	{
		$oBreadcrumb = new Breadcrumb();
		foreach ( $aValue as $key => $value ) {
			$oBreadcrumb->append_crumb($key, $value);
		}
		$sBreadcrumb = $oBreadcrumb->output();
		return $sBreadcrumb;
	}
}
?>