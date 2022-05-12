<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
for( $ii = 1; $ii <= 20; $ii++ ){
	$config['settings']['fields:misc' . $ii . ':label'] = '';
	$config['settings']['fields:misc' . $ii . ':use'] = 0;

	$config['settings']['front_map:misc' . $ii . ':show'] = 0;
	$config['settings']['front_map:misc' . $ii . ':w_label'] = 0;

	$config['settings']['front_list:misc' . $ii . ':show'] = 0;
	$config['settings']['front_list:misc' . $ii . ':w_label'] = 0;
}