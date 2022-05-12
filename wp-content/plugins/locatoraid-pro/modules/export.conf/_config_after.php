<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/app.conf/form'][] = function( $app, $return )
{
	$return['core:csv_separator'] = array(
		'input'	=> $app->make('/form/select')
			->set_options( 
				array(
					','	=> ',',
					';'	=> ';',
					)
				),
		'label'	=> HCM::__('CSV Delimiter'),
		);
	return $return;
};
