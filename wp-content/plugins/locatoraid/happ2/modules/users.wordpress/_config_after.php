<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['after']['/conf/view/layout->tabs'][] = function( $app, $return )
{
	$return['users'] = array( 'users.wordpress', HCM::__('Users') );
	return $return;
};

$config['after']['/users/index/view/layout->menubar'][] = function( $app, $return )
{
	$return['settings'] = $app->make('/html/ahref')
		->to('/users.wordpress-conf')
		->add( $app->make('/html/icon')->icon('cog') )
		->add( HCM::__('Settings') )
		;

	if( current_user_can('create_users') ){
		$link = admin_url( 'user-new.php' );
		$return['add'] = $app->make('/html/ahref')
			->to($link)
			->add( $app->make('/html/icon')->icon('plus') )
			->add( HCM::__('Add New') )
			;
	}

	return $return;
};
