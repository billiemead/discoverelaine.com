<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_New_Controller_LC_HC_MVC
{
	public function execute()
	{
		$view = $this->app->make('/products/new/view')
			->render()
			;
		$view = $this->app->make('/products/new/view/layout')
			->render($view)
			;
		$view = $this->app->make('/layout/view/body')
			->set_content($view)
			;
		return $this->app->make('/http/view/response')
			->set_view($view)
			;
	}
}