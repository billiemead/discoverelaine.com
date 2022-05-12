<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/search/view/prepare'][] = function( $app, $return )
{
	foreach( array_keys($return) as $ii ){
		if( ! isset($return[$ii]['product']) ){
			continue;
		}

		if( ! $return[$ii]['product'] ){
			unset( $return[$ii]['product'] );
			continue;
		}

		if( ! (isset($return[$ii]['product']) && $return[$ii]['product']) ){
			continue;
		}

		$products = $return[$ii]['product'];
		$products_view = array();
		foreach( $products as $e ){
			$products_view[] = $e['title'];
		}
		$products_view = join(', ', $products_view);

		$return[$ii]['product_raw'] = $return[$ii]['product'];
		$return[$ii]['product'] = $products_view;
	}

	return $return;
};