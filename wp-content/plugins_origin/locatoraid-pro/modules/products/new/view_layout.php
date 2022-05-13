<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_New_View_Layout_LC_HC_MVC
{
	public function header()
	{
		$return = HCM::__('Add New Product');
		return $return;
	}

	public function menubar()
	{
		$return = array();

	// LIST
		$p = $this->app->make('/locations/presenter');
		$labels = $p->fields_labels();
		$fn = 'product';
		$label = array_key_exists($fn, $labels) ? $labels[$fn] : HCM::__('Products');

		$return['list'] = $this->app->make('/html/ahref')
			->to('/products')
			->add( $this->app->make('/html/icon')->icon('arrow-left') )
			->add( $label )
			;

		return $return;
	}

	public function render( $content )
	{
		$this->app->make('/layout/top-menu')
			->set_current( 'products' )
			;

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