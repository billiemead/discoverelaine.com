<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Conf_Controller_HC_MVC
{
	public function execute()
	{
		$view = $this->app->make('/products.conf/view')
			->render()
			;
		$view = $this->app->make('/conf/view/layout')
			->render( $view, 'products' )
			;
		$view = $this->app->make('/layout/view/body')
			->set_content($view)
			;
		return $this->app->make('/http/view/response')
			->set_view($view)
			;
	}
}