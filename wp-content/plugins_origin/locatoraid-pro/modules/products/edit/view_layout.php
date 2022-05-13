<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Edit_View_Layout_LC_HC_MVC
{
	public function header( $model )
	{
		$return = HCM::__('Edit Product');
		return $return;
	}

	public function menubar( $model )
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

	public function render( $content, $model )
	{
		$this->app->make('/layout/top-menu')
			->set_current( 'products' )
			;

		$menubar = $this->menubar($model);
		$header = $this->header($model);

		$out = $this->app->make('/layout/view/content-header-menubar')
			->set_content( $content )
			->set_header( $header )
			->set_menubar( $menubar )
			;

		return $out;
	}
}