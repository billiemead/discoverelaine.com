<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$handle_products = function( $app, $return, $id = NULL )
{
	static $all_products = NULL;

	$my_products = array();
	foreach( $return as $k => $v ){
		if( substr($k, 0, strlen('product:')) == 'product:' ){
			$product_name = substr($k, strlen('product:'));
			unset( $return[$k] );
			if( strlen($v) ){
				$my_products[$product_name] = $product_name;
			}
		}
	}

	if( ! $my_products ){
		return $return;
	}

// now check if we have this products
	if( $all_products === NULL ){
		$all_products = array();
		$products = $app->make('/products/commands/read')
			->execute()
			;
		foreach( $products as $p ){
			$all_products[ $p['title'] ] = $p;
		}
	}

	$to_create = array();
	reset( $my_products );
	foreach( $my_products as $e_title ){
		if( ! array_key_exists($e_title, $all_products) ){
			$to_create[ $e_title ] = $e_title;
		}
	}

	if( $to_create ){
		reset( $to_create );
		foreach( $to_create as $e_title ){
			$values = array(
				'title'	=> $e_title
				);

			$cm = $app->make('/commands/manager');
			$command = $app->make('/products/commands/create');
			$command
				->execute( $values )
				;
			$response = $cm->results( $command );
			$all_products[ $response['title'] ] = $response;
		}
	}

	// now check my product prop
	$my_prop = array();
	reset( $my_products );
	foreach( $my_products as $e_title ){
		if( ! isset($all_products[$e_title]) ){
			continue;
		}
		$my_prop[] = $all_products[ $e_title ]['id'];
	}
	$return['product'] = $my_prop;

	return $return;
};

$config['after']['/locations/commands/update->prepare'][] = $handle_products;
$config['after']['/locations/commands/create->prepare'][] = $handle_products;

$config['after']['/locations/presenter->fields'][] = function( $app, $return )
{
	$return['product'] = HCM::__('Products');
	return $return;
};

$config['after']['/locations/form'][] = function( $app, $return )
{
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

	$return['product'] = array(
		'input'	=> $app->make('/form/checkbox-set')
			->set_options( $options ),
		'label'	=> HCM::__('Products')
		);

	return $return;
};

$config['after']['/locations/index/view->header'][] = function( $app, $return )
{
	$app_settings = $app->make('/app/settings');
	$this_field_pname = 'fields:' . 'product'  . ':use';
	$this_field_conf = $app_settings->get($this_field_pname);
	if( ! $this_field_conf ){
		return $return;
	}

	$p = $app->make('/locations/presenter');
	$labels = $p->fields_labels();
	$fn = 'product';
	$label = array_key_exists($fn, $labels) ? $labels[$fn] : HCM::__('Products');

	$return['product'] = $label;
	return $return;
};

$config['after']['/locations/index/view->row'][] = function( $app, $return, $e )
{
	$app_settings = $app->make('/app/settings');
	$this_field_pname = 'fields:' . 'product'  . ':use';
	$this_field_conf = $app_settings->get($this_field_pname);
	if( ! $this_field_conf ){
		return $return;
	}

	$p = $app->make('/locations.products/presenter');
	$return['product'] = $p->present_products( $e );

	return $return;
};