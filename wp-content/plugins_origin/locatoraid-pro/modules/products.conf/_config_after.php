<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/conf/view/layout->tabs'][] = function( $app, $return )
{
	$return['products'] = array( 'products.conf', HCM::__('Products') );
	return $return;
};