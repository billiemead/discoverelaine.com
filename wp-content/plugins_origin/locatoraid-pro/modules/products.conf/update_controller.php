<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Conf_Update_Controller_HC_MVC
{
	public function execute()
	{
		$form = $this->app->make('/products.conf/form');
		return $this->app->make('/conf/update/controller')
			->execute( $form )
			;
	}
}