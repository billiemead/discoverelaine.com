<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Conf_View_HC_MVC
{
	public function render()
	{
		$form = $this->app->make('/products.conf/form');
		$to = '/products.conf/update';

		return $this->app->make('/conf/view')
			->render( $form, $to )
			;
	}
}