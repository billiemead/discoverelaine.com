<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['relations']['locations']['product'] = array( 
	'their_class'		=> 'products',
	'relation_name'		=> 'product_to_location',
	'their_field'		=>	'from_id',
	'many'				=>	TRUE,
	);
