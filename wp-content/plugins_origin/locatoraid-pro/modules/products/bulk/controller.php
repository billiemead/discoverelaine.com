<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Bulk_Controller_LC_HC_MVC
{
	public function execute()
	{
		$post = $this->app->make('/input/lib')->post();

		$inputs = $this->app->make('/products/bulk/form')
			->inputs()
			;
		$helper = $this->app->make('/form/helper');

		list( $values, $errors ) = $helper->grab( $inputs, $post );

		if( $errors ){
			return $this->app->make('/http/view/response')
				->set_redirect('-referrer-') 
				;
		}

		$action = $values['action'];

		switch( $action ){
			case 'delete':
				return $this->_execute_delete( $values );
				break;

			case 'order':
				return $this->_execute_order( $values );
				break;
		}
	}

	protected function _execute_order( $values )
	{
		$entries = $this->app->make('/products/commands/read')
			->execute()
			;

		$config = array();
		foreach( $entries as $e ){
			$config[ (int) $e['id'] ] = (int) $values['show_order_' . $e['id']];
		}
		$config = json_encode( $config );

		$values = array( 'products:show_order' => $config );

		$response = $this->app->make('/conf/commands/update')
			->execute( $values )
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

	protected function _execute_delete( $values )
	{
		$command = $this->app->make('/products/commands/delete');

		$ids = $values['id'];
		foreach( $ids as $id ){
			$response = $command
				->execute( $id )
				;
			if( isset($response['errors']) ){
				echo $response['errors'];
				exit;
			}
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