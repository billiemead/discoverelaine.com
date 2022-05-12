<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Delete_Controller_LC_HC_MVC
{
	public function execute( $id )
	{
		$command = $this->app->make('/products/commands/delete');
		$response = $command
			->execute( $id )
			;

		if( isset($response['errors']) ){
			echo $response['errors'];
			exit;
		}

	// OK
		$redirect_to = $this->app->make('/http/uri')
			->url('/products')
			;
		return $this->app->make('/http/view/response')
			->set_redirect($redirect_to) 
			;
	}
}