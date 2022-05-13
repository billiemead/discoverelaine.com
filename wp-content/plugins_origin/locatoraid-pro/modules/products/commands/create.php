<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Commands_Create_LC_HC_MVC
{
	public function execute( $values )
	{
		$cm = $this->app->make('/commands/manager');

		$validators = $this->validators();
		$errors = $this->app->make('/validate/helper')
			->validate( $values, $validators )
			;
		if( $errors ){
			$cm->set_errors( $this, $errors );
			return;
		}

		$command = $this->app->make('/commands/create')
			->set_table('products')
			;
		$command->execute( $values );

		$errors = $cm->errors( $command );
		if( $errors ){
			$cm->set_errors( $this, $errors );
			return;
		}

		$results = $cm->results( $command );
		$cm->set_results( $this, $results );

		$this->app
			->after( $this, $this )
			;
	}

	public function validators()
	{
		$return = array();

		$return['title'] = array(
			$this->app->make('/validate/required'),
			$this->app->make('/validate/maxlen')
				->params( 250 ),
			$this->app->make('/validate/unique')
				->params( 'products', 'title' )
			);

		$return = $this->app
			->after( array($this, __FUNCTION__), $return )
			;

		return $return;
	}
}