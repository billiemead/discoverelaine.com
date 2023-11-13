<?php

add_action( 'wp_enqueue_scripts', 'Divi_child_style' );
function Divi_child_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css',array('parent-style'));
}

/*function dl_custom_footer() {
	echo do_shortcode('[et_pb_section global_module="1614"][/et_pb_section]');
}
add_action('et_after_main_content', 'dl_custom_footer');*/

/*function load_css() {
	wp_register_style('wpwp', get_theme_file_uri() . '/css/wpwp_custom.css', array(), false, 'all' );
	wp_enqueue_style('wpwp');
}
add_action('wp_enqueue_scripts', 'load_css');*/

/*function load_js() {
	wp_register_script('wpwp_js', get_theme_file_uri() . '/js/wpwp_custom.js', 'jquery', false, true );
	wp_enqueue_script('wpwp_js');
}
add_action('wp_enqueue_scripts', 'load_js');*/

// smacss
function es_assets() {
	wp_register_style( 'es-stylesheet', get_theme_file_uri() . '/dist/css/bundle.css', array(), '1.0.0', 'all' );
	wp_enqueue_style('es-stylesheet');
	wp_enqueue_script('es_js', get_theme_file_uri() . '/dist/js/bundle.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'es_assets');
