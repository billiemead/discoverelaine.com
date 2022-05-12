<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Index_View_Layout_LC_HC_MVC
{
	public function header()
	{
		$p = $this->app->make('/locations/presenter');
		$labels = $p->fields_labels();
		$fn = 'product';
		$return = array_key_exists($fn, $labels) ? $labels[$fn] : HCM::__('Products');

		return $return;
	}

	public function menubar()
	{
		$return = array();

		$return['new'] = $this->app->make('/html/ahref')
			->to('/products/new')
			->add( $this->app->make('/html/icon')->icon('plus') )
			->add( HCM::__('Add New') )
			;

		$return['settings'] = $this->app->make('/html/ahref')
			->to('/products.conf')
			->add( $this->app->make('/html/icon')->icon('cog') )
			->add( HCM::__('Settings') )
			;

		return $return;
	}

	public function render( $content )
	{
		$header = $this->header();
		$menubar = $this->menubar();

		$out = $this->app->make('/layout/view/content-header-menubar')
			->set_content( $content )
			->set_header( $header )
			->set_menubar( $menubar )
			;

		return $out;
	}
}