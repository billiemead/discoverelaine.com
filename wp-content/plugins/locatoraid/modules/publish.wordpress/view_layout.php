<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Publish_Wordpress_View_Layout_LC_HC_MVC
{
	public function header()
	{
		$return = HCM::__('Publish');
		return $return;
	}

	public function menubar()
	{
		$return = array();
		return $return;
	}

	public function render( $content )
	{
		$header = $this->header();
		$menubar = $this->menubar();

		$out = $this->app->make('/layout/header-menubar-sidebar-content')
			->set_content( $content )
			->set_header( $header )
			->set_menubar( $menubar )
			;

		return $out;
	}
}