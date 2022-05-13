<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/export/presenter'][] = function( $app, $return, $data )
{
	$products = array();
	if( isset($data['products']) ){
		$products = $data['products'];
	}
	elseif( isset($data['product']) ){
		$products = $data['product'];
	}

	if( ! $products ){
		return $return;
	}

	foreach( $products as $e ){
		$pname = 'product:' . $e['title'];
		$return[$pname] = 'x';
	}

	return $return;
};

$config['after']['/locations/presenter->database_fields'][] = function( $app, $return )
{
	$products = $app->make('/products/commands/read')
		->execute()
		;

	if( ! $products ){
		return $return;
	}

	foreach( $products as $e ){
		$return[] = 'product:' . $e['title'];
	}

	return $return;
};