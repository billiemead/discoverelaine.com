<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/front/form'][] = function( $app, $return )
{
	$app_settings = $app->make('/app/settings');
	$this_field_pname = 'fields:' . 'product'  . ':use';
	$this_field_conf = $app_settings->get($this_field_pname);
	if( ! $this_field_conf ){
		return $return;
	}

	$products = $app->make('/products/commands/read')
		->execute()
		;
	if( ! $products ){
		return $return;
	}

	$options = array();
	foreach( $products as $e ){
		$options[ $e['id'] ] = $e['title'];
	}

	$p = $app->make('/locations/presenter');
	$labels = $p->fields_labels();
	$fn = 'product';
	$label = array_key_exists($fn, $labels) ? $labels[$fn] : HCM::__('Products');

	$return['product'] = array(
		'input'	=> $app->make('/form/checkbox-set')
			->set_options( $options )
			,
		// 'label'	=> $label,
		);

	return $return;
};
