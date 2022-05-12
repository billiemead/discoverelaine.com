<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/layout/top-menu'][] = function( $app, $return )
{
	$app_settings = $app->make('/app/settings');
	$this_field_pname = 'fields:' . 'product'  . ':use';
	$this_field_conf = $app_settings->get( $this_field_pname );
	if( ! $this_field_conf ){
		return $return;
	}

	$p = $app->make('/locations/presenter');
	$labels = $p->fields_labels();
	$fn = 'product';
	$label = array_key_exists($fn, $labels) ? $labels[$fn] : HCM::__('Products');

	$link = $app->make('/html/ahref')
		->to('/products')
		->add( $app->make('/html/icon')->icon('tag') )
		->add( $label )
		;

	$return['products'] = array( $link, 10 );
	return $return;
};
