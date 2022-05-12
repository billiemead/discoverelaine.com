<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Edit_Controller_LC_HC_MVC
{
	public function execute( $id )
	{
		$model = $this->app->make('/products/commands/read')
			->execute( $id )
			;

		$view = $this->app->make('/products/edit/view')
			->render($model)
			;
		$view = $this->app->make('/products/edit/view/layout')
			->render($view, $model)
			;
		$view = $this->app->make('/layout/view/body')
			->set_content($view)
			;
		return $this->app->make('/http/view/response')
			->set_view($view) 
			;
	}
}