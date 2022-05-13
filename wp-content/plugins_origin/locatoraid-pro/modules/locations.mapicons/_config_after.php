<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$handle_mapicon = function( $app, $return, $id = NULL )
{
	if( ! array_key_exists('mapicon', $return) ){
		return $return;
	}
	if( ! $return['mapicon'] ){
		return $return;
	}
	if( preg_match('/^\d+$/', $return['mapicon'])){
		return $return;
	}

// is not url?
	if( ! HC_Lib2::is_full_url($return['mapicon']) ){
		$return['mapicon'] = NULL;
		return $return;
	}

	$image_url = $return['mapicon'];
// try to locate the attachment id
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
	if( $attachment && isset($attachment[0]) ){
		$image_id = $attachment[0];
		if( $image_id ){
			$return['mapicon'] = $image_id;
			return $return;
		}
	}

// else grab it by the URL and upload to here
	if( ! class_exists('WP_Http') ){
		include_once( ABSPATH . WPINC. '/class-http.php' );
	}

	static $urls2id = array();

	if( ! isset($urls2id[$image_url]) ){
		$image = new WP_Http();
		$image = $image->request( $image_url );
		if( $image instanceof WP_Error ){
			return $return;
		}

		$short_name = basename( $image_url );

		static $upload_id = 0;
		$upload_id++;
		$attachment = wp_upload_bits( 
			$short_name,
			NULL,
			$image['body'],
			date("Y-m", strtotime($image['headers']['last-modified'])) 
			);

		if( isset($attachment['error']) && $attachment['error'] ){
			$msgbus = $app->make('/msgbus/lib');
			$msg = $short_name . ': ' . $attachment['error'];
			$msg_key = 'location' . '-add-' . $upload_id;
			$group_msg = FALSE;
			$msgbus->add('error', $msg, $msg_key, $group_msg);
			$return['mapicon'] = NULL;
			return $return;
		}
		$filetype = wp_check_filetype( basename( $attachment['file'] ), NULL );

		$postinfo = array(
			'post_mime_type'	=> $filetype['type'],
			'post_title'		=> 'Map Icon',
			'post_content'	=> '',
			'post_status'	=> 'inherit',
		);
		$filename = $attachment['file'];
		$image_id = wp_insert_attachment( $postinfo, $filename );

		$urls2id[$image_url] = $image_id;
	}

	if( isset($urls2id[$image_url]) ){
		$image_id = $urls2id[$image_url];
		$return['mapicon'] = $image_id;
	}

	return $return;
};

$config['after']['/locations/commands/update->prepare'][] = $handle_mapicon;
$config['after']['/locations/commands/create->prepare'][] = $handle_mapicon;

$config['after']['/locations/index/view->row'][] = function( $app, $return, $e )
{
	$p = $app->make('/locations/presenter');
	$icon_view = $p->present_icon( $e );

	// $return['title'] = $app->make('/html/list-inline')
		// ->add( $icon_view )
		// ->add( $return['title'] )
		// ;

	// $return['title'] = $app->make('/html/element')->tag('div')
		// ->add( $return['title'] )
		// ->add_attr('class', 'hc-nowrap')
		// ;

	$return['icon'] = $icon_view;

	return $return;
};

$config['after']['/locations/index/view->header'][] = function( $app, $return )
{
	$return['icon'] = HCM::__('Map Icon');
	return $return;
};


$config['after']['/locations/edit/form'][] = function( $app, $return )
{
	$return['mapicon'] = array(
		'input'	=> $app->make('/mapicons/input'),
		'label'	=> HCM::__('Map Icon')
		);
	return $return;
};
