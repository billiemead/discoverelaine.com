<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
require( dirname(__FILE__) . '/_common.php' );

$config['nts_app_title'] = 'Locatoraid Pro';

$config['modules'] = array_merge( $config['modules'], array(
	'wordpress',
	'widget',
	'silentsetup',

	'coordinates',
	'priority',

	'import',
	'export',

	'products',

	'custom_fields',
	'directions',

	'publish',
	'mapicons',
	'searchlog',
	'rest',
	)
);
