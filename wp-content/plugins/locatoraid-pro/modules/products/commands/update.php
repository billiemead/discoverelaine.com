<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Commands_Update_LC_HC_MVC
{
	public function execute( $id, $values = array() )
	{
		$cm = $this->app->make('/commands/manager');

		$validators = $this->validators( $id );
		$errors = $this->app->make('/validate/helper')
			->validate( $values, $validators )
			;
		if( $errors ){
			$cm->set_errors( $this, $errors );
			return;
		}

		$command = $this->app->make('/commands/update')
			->set_table('products')
			;
		$command->execute( $id, $values );

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

	public function validators( $id )
	{
		$return = array();

		$return['title'] = array(
			$this->app->make('/validate/required'),
			$this->app->make('/validate/maxlen')
				->params( 250 ),
			$this->app->make('/validate/unique')
				->params( 'products', 'title', $id )
			);

		$return = $this->app
			->after( array($this, __FUNCTION__), $return )
			;

		return $return;
	}
}