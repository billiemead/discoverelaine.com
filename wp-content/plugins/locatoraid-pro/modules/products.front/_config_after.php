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
		// $options[ $e['id'] ] = $e['title'];
		$options[ $e['id'] ] = '<div id="locatoraid-search-form-product-' . $e['id'] . '">' . $e['title'] . '</div>';
	}

	$p = $app->make('/locations/presenter');
	$labels = $p->fields_labels();
	$fn = 'product';
	$label = array_key_exists($fn, $labels) ? $labels[$fn] : HCM::__('Products');

	$app_settings = $app->make('/app/settings');
	$select_type = $app_settings->get('front:product:select_type');

	if( ! $select_type ){
		$select_type = 'checkbox';
	}

	if( $select_type == 'none' ){
		unset( $return['product'] );
	}
	elseif( $select_type == 'checkbox' ){
		$return['product'] = 
			$app->make('/form/checkbox-set')
				->set_options( $options )
			;
	}
	else {
		$return['product'] = 
			$app->make('/form/radio')
				->set_options( $options )
			;
	}

	return $return;
};
