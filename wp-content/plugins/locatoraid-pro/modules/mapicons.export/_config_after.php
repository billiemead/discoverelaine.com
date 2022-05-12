<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/export/presenter'][] = function( $app, $return, $data )
{
	$mapicon = isset( $data['mapicon'] ) ? $data['mapicon'] : NULL;
	$return['mapicon'] = $mapicon;
	return $return;
};

$config['after']['/locations/presenter->database_fields'][] = function( $app, $return )
{
	$return[] = 'mapicon';
	return $return;
};