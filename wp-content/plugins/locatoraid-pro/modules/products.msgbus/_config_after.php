<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/products/commands/create'][] = function( $app )
{
	$msg_key = 'products-create';
	$msgbus = $app->make('/msgbus/lib');

	$msg = HCM::__('Product Added');
	$msgbus->add('message', $msg, $msg_key, TRUE);
};

$config['after']['/products/commands/update'][] = function( $app )
{
	$msg_key = 'products-update';
	$msgbus = $app->make('/msgbus/lib');

	$msg = HCM::__('Product Updated');
	$msgbus->add('message', $msg, $msg_key, TRUE);
};

$config['after']['/products/commands/delete'][] = function( $app )
{
	$msg_key = 'products-delete';
	$msgbus = $app->make('/msgbus/lib');

	$msg = HCM::__('Product Deleted');
	$msgbus->add('message', $msg, $msg_key, TRUE);
};
