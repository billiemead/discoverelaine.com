<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/conf/view/layout->tabs'][] = function( $app, $return )
{
	$return['app'] = array( 'app.conf', HCM::__('Configuration') );
	return $return;
};
