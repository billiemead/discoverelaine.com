<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Index_Controller_LC_HC_MVC
{
	public function execute()
	{
		$entries = $this->app->make('/products/commands/read')
			->execute()
			;

		$view = $this->app->make('/products/index/view')
			->render($entries)
			;
		$view = $this->app->make('/products/index/view/layout')
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