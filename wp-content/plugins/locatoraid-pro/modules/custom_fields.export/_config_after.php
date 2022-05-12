<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/locations/presenter->database_fields'][] = function( $app, $return )
{
	$qty = 20;
	for( $ii = 1; $ii <= $qty; $ii++ ){
		$fn = 'misc' . $ii;
		$return[] = $fn;
	}
	return $return;
};