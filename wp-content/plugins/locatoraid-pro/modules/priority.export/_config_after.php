<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/locations/presenter->database_fields'][] = function( $app, $return )
{
	$return[] = 'priority';
	return $return;
};