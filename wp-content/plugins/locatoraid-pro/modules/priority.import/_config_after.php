<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/import/presenter->fields'][] = function( $app, $return )
{
	$return[1][] = 'priority';
	return $return;
};