<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['relations']['products']['locations'] = array( 
	'their_class'		=> 'locations',
	'relation_name'		=> 'product_to_location',
	'their_field'		=>	'to_id',
	'many'				=>	TRUE,
	);