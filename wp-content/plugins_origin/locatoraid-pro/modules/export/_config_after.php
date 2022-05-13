<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/layout/top-menu'][] = function( $app, $return )
{
	$link = $app->make('/html/ahref')
		->to('/export')
		->add( $app->make('/html/icon')->icon('download') )
		->add( HCM::__('Export') )
		;
	$return['export'] = array( $link, 2 );

	return $return;
};
