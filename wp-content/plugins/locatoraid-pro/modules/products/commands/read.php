<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Commands_Read_LC_HC_MVC
{
	public function args( $return = array() )
	{
		if( ! is_array($return) ){
			$return = array( $return );
		}

		$return[] = array('sort', 'title', 'asc');

		$return = $this->app
			->after( array($this, __FUNCTION__), $return )
			;
		return $return;
	}

	public function execute( $args = array() )
	{
		$args = $this->args( $args );

		$command = $this->app->make('/commands/read')
			->set_table('products')
			;
		$return = $command
			->execute( $args )
			;

		if( count($return) && ( ! isset($return['id']) ) ){
			$app_settings = $this->app->make('/app/settings');
			$show_order = $app_settings->get('products:show_order');
			$show_order = strlen( $show_order ) ? json_decode($show_order, TRUE) : array();

			$last_show_order = 1;
			foreach( $return as $id => $e ){
				$this_show_order = ( isset($show_order[$id]) ) ? $show_order[$id] : $last_show_order;
				$return[$id]['show_order'] = $this_show_order;
				$last_show_order = $this_show_order + 1;
			}
			uasort( $return, array($this, '_sort') );
		}

		$return = $this->app
			->after( $this, $return )
			;
		return $return;
	}
	
	protected function _sort( $a, $b )
	{
		return ($a['show_order'] - $b['show_order']);
	}
}