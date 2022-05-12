<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/import/presenter->fields'][] = function( $app, $return )
{
	$qty = 20;
	for( $ii = 1; $ii <= $qty; $ii++ ){
		$input_name = 'misc' . $ii;
		$return[1][] = $input_name;
	}
	return $return;
};