<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/locations/presenter->present_icon_url'][] = function( $app, $return, $data )
{
	$mapicon_id = isset($data['mapicon']) ? $data['mapicon'] : NULL;
	if( ! $mapicon_id ){
		return $return;
	}

	$your_img_src = wp_get_attachment_image_src( $mapicon_id, 'full' );
	$have_img = is_array( $your_img_src );
	if( ! $have_img ){
		return $return;
	}

	$return = $your_img_src[0];
	return $return;
};
