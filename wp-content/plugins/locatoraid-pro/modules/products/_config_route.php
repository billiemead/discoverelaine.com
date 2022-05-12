<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['route']['products']				= '/products/index/controller';
$config['route']['products/{id}/edit']		= '/products/edit/controller';
$config['route']['products/{id}/update']	= '/products/edit/controller/update';
$config['route']['products/{id}/delete']	= '/products/delete/controller';

$config['route']['products/add']			= '/products/new/controller/add';
