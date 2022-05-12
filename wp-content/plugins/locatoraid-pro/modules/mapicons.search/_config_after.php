<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/search/view/prepare'][] = function( $app, $return )
{
	foreach( array_keys($return) as $ii ){
		if( ! (isset($return[$ii]['mapicon']) && $return[$ii]['mapicon']) ){
			continue;
		}

		$icon_img_id = $return[$ii]['mapicon'];
		$icon_url = wp_get_attachment_image_src( $icon_img_id, 'full' );

		$return[$ii]['mapicon'] = $icon_url[0];
	}

	return $return;
};