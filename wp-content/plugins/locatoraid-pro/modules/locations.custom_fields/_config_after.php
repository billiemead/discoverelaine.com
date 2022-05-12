<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/locations/presenter->fields'][] = function( $app, $return )
{
	$qty = 20;
	for( $ii = 1; $ii <= $qty; $ii++ ){
		$fn = 'misc' . $ii;
		$return[ $fn ] = HCM::__('Misc') . ' #' . $ii;
	}
	return $return;
};

$config['after']['/locations/form'][] = function( $app, $return )
{
	$app_settings = $app->make('/app/settings');

	$inputs = array();
	for( $ii = 1; $ii <= 20; $ii++ ){
		$fn = 'misc' . $ii;
		$label = $fn;
		$return[$fn] = array(
			'input'	=> $app->make('/form/text'),
			'label'	=> $label,
			);
	}

	return $return;
};
