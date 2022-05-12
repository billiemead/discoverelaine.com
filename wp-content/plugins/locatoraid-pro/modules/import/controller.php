<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Import_Controller_LC_HC_MVC
{
	public function execute()
	{
		$view = $this->app->make('/import/view')
			->render()
			;
		$view = $this->app->make('/import/view/layout')
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