<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/layout/top-menu'][] = function( $app, $return )
{
	$link = $app->make('/html/ahref')
		->to('/import')
		->add( $app->make('/html/icon')->icon('upload') )
		->add( HCM::__('Import') )
		;
	$return['import'] = array( $link, 3 );

	return $return;
};
