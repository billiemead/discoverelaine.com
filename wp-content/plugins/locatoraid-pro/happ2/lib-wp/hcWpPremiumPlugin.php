<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$checker_file = dirname(__FILE__) . '/plugin-update-checker.php';
if( (! class_exists('hcWpPremiumPlugin2')) && file_exists($checker_file) )
{
include_once( $checker_file );

class hcWpPremiumPlugin2
{
	protected $app = '';
	protected $app_full_name = '';
	protected $my_type = 'wp'; // or wp
	protected $checker = NULL;
	protected $hc_product = '';
	protected $full_path = '';

	function __construct( 
		$app,			// app short name and slug
		$product,		// plainware product name
		$app_full_name,		// app full name
		$full_path		// full path of the original plugin file
		)
	{
		$this->app = $app;
		$this->app_full_name = $app_full_name;
		$this->hc_product = $product;
		$this->full_path = $full_path;

		if( defined('NTS_DEVELOPMENT2') ){
			$check_url = 'http://localhost/codeseller/update.php?';
		}
		else {
			$check_url = 'https://www.plainware.com/customers/update.php?';
		}
		$check_url .= '&slug=' . $product;

		$check_period = 24;

		$this->checker = new PluginUpdateChecker_1_5 (
			$check_url,
			$full_path,
			$product,
			$check_period
			);

		$this->checker->addQueryArgFilter( array($this, 'give_code_to_checker') );

	// add more links in plugin list
		add_action( 'after_plugin_row_' . plugin_basename($full_path), array($this, 'license_details'), 10, 3 );

		if( is_multisite() )
			$filter_name = 'network_admin_plugin_action_links_' . plugin_basename($full_path);
		else
			$filter_name = 'plugin_action_links_' . plugin_basename($full_path);
		add_filter( $filter_name, array($this, 'license_link') );

	// reset check period after license code change
		$option_name = $this->app . '_license_code';
		add_action( 'update_site_option_' . $option_name, array($this, 'reset_license') );
	}

	public function give_code_to_checker( $args )
	{
		$args['code'] = $this->get_license();
		return $args;
	}

	public function reset_license()
	{
		$option_name = 'external_updates-' . $this->hc_product;
		delete_site_option( $option_name );
		$this->checker->checkForUpdates();
	}

	static function reset_license_code( $product )
	{
		$option_name = 'external_updates-' . $product;
		delete_site_option( $option_name );
	}

	function license_details( $plugin_file, $plugin_data, $status )
	{
		if( ! current_user_can('update_plugins') )
			return;

		$license_code = $this->get_license();
		$download_url = '';
		if( $license_code )
		{
			$state = $this->checker->getUpdateState();
			$notice = isset($state->update->upgrade_notice) ? $state->update->upgrade_notice : '';
			$download_url = isset($state->update->download_url) ? $state->update->download_url : '';

			if( $notice && (! $download_url) )
			{
//				$notice = 'License error: ' . $notice;
			}
		}
		else
		{
			$notice = 'License is not set yet. ';
		}

		if( $notice )
		{
			$url = $this->get_license_link();
			$license_link = '<a href="' . $url . '">' . 'Enter license code to enable automatic updates' . '</a>';

			$return = array();
			$return[] = '<tr class="plugin-update-tr active">';
			$return[] = '<td colspan="3" style="padding: 0.5em 0 0 0; border: 0;">';

			if( $download_url ){
				$return[] = '<div class="update-message notice inline notice-success notice-alt"><p>';
			}
			else {
				$return[] = '<div class="update-message notice inline notice-error notice-alt"><p>';
			}

			$return[] = $notice;

			if( ! $license_code )
			{
				if( current_user_can('update_plugins') )
				{
					$return[] = ' ' . $license_link;
//					$return[] = '<br>';
					$return[] = ' ';
				}
			}
			$return[] = '</div>';

			$return[] = '</td>';
			$return[] = '</tr>';
			$return = join( '', $return );
			echo $return;
		}
	}

	public function get_license()
	{
		$return = '';

		switch( $this->my_type )
		{
			case 'wp':
				$option_name = $this->app . '_license_code';
				$return = get_site_option( $option_name );
				break;

			case 'own':
				global $wpdb;
				$db_prefix = $GLOBALS['NTS_CONFIG'][$this->app]['DB_TABLES_PREFIX'];
				$return = NULL;

				$mytable = $db_prefix . 'conf';
				$sql = "SELECT value FROM $mytable WHERE name='license_code'";
				$return = $wpdb->get_var( $sql );
				break;
		}

		return $return;
	}

	public function get_license_link()
	{
		switch( $this->my_type )
		{
			case 'wp':
				$license_url = $this->app . '-license';
				break;

			case 'own':
				$license_url = $this->app . '&/license/admin';
				break;
		}

		if( is_multisite() ){
			$return = add_query_arg( 
				array(
					'page' => $license_url,
					),
				network_admin_url('admin.php')
				);
		}
		else {
			$return = add_query_arg( 
				array(
					'page' => $license_url,
					),
				admin_url('admin.php')
				);
		}
		return $return;
	}

	public function license_link( $links )
	{
		$url = $this->get_license_link();

		$link_title = __( 'License Code' );
		switch( $this->my_type )
		{
			case 'wp':
				$link_title = __( 'License & Options' );
				break;
			case 'own':
				$link_title = __( 'License Code' );
				break;
		}

		$license_link = '<a href="' . $url . '">' . $link_title . '</a>';
		array_unshift( $links, $license_link );
		return $links;
	}

	/* these ones add functionality for the main plugin class */
	public function admin_init()
	{
		register_setting( $this->app, $this->app . '_license_code' );
		register_setting( $this->app, $this->app . '_menu_title' );
	}

	public function admin_submenu()
	{
		$page = add_submenu_page(
			NULL,
			'',
			'',
			'update_plugins',
			$this->app . '-license',
			array( $this, 'dev_options' )
			);
	}

	static function uninstall( $prefix )
	{
		$current = array();
		$current['license_code'] = get_site_option( $prefix . '_license_code', '' );
		$installation_id = '';

	// delete options
		delete_site_option( $prefix . '_license_code' );
		delete_site_option( $prefix . '_menu_title' );
	}

	public function dev_options()
	{
		$current = array();
		$current['license_code'] = get_site_option( $this->app . '_license_code', '' );

		$product_title = $this->app_full_name;
		$product_title = str_replace( '_', ' ', $product_title );
		$product_title = str_replace( '-', ' ', $product_title );
		$product_title = ucwords( $product_title );
		$current['menu_title'] = get_site_option( $this->app . '_menu_title', $product_title );

		if( defined('NTS_DEVELOPMENT2') )
			$check_license_url = 'http://localhost/codeseller/lic.php';
		else
			$check_license_url = 'https://www.plainware.com/customers/lic.php';

		if( isset($_POST[$this->app . '_submit']) ){
			if( isset($_POST[$this->app]) ){
				foreach( (array)$_POST[$this->app] as $key => $value ){
					$option_name = $this->app . '_' . $key;
					$value = sanitize_text_field( $value );
					update_site_option( $option_name, $value );
				}

				$current['license_code'] = get_site_option( $this->app . '_license_code', '' );
				$current['menu_title'] = get_site_option( $this->app . '_menu_title', ucfirst($this->app) );
			}
		}

		$check_url = 
			$check_license_url . 
			'?code=' . $current['license_code'] . 
			'&prd=' . urlencode($this->hc_product)
			;

		if( defined('NTS_DEVELOPMENT2') ){
			echo '<br><br>' . $check_url . '<br>';
		}

		$license_status_view = '';
		if( strlen($current['license_code']) ){
			// $check_url2 = $check_url . '&action=json';
			$check_url2 = $check_url;
			$response = wp_remote_get(
				$check_url2,
				array(
					'timeout'	=> 5,
					'sslverify'	=> FALSE,
					)
				);

			if( is_array($response) && isset($response['body']) && strlen($response['body']) ){
				$body = $response['body']; // use the content
				$status_vars = json_decode( $body, TRUE );
				if( $status_vars === NULL ){
					$license_status_view = "Error connecting to the license server: '$body'";
				}
				else {
					$license_status_view = "<div class=\"";
					$license_status_view .= "\"";

					if( $status_vars['status'] ){
						$license_status_view .= " style=\"border: #090 1px solid; padding: 0.5em; color: #060;\"";
					}
					else {
						$license_status_view .= " style=\"border: #900 1px solid; padding: 0.5em; color: #600;\"";
					}

					$license_status_view .= ">";

					$license_status_view .= $status_vars['text'];
					$license_status_view .= "</div>";
				}
			}
			else {
				$license_status_view = "Error connecting to the license server";
				if( isset($response->errors) && $response->errors ){
					// _print_r( $response );
					$license_status_view .= '<br/>';
					foreach( $response->errors as $k => $v ){
						$license_status_view .= $k . ': ';
						$license_status_view .= join(', ', $v);
						$license_status_view .= '<br/>';
					}
				}
			}
		}
		// spaghetti starts here
?>

<div class="wrap">
<h2><?php echo $product_title; ?> Options</h2>

<?php if( isset($_POST[$this->app . '_submit']) ) : ?>
	<div id="message" class="updated fade">
		<p>
			<?php _e( 'Settings Saved', 'my' ) ?>
		</p>
	</div>
<?php endif; ?>

<form method="post" action="">
	<?php settings_fields( $this->app ); ?>
	<?php //do_settings_sections( $this->app ); ?>
	<table class="form-table">
		<tr valign="top">
		<th scope="row">Menu Title</th>
		<td><input type="text" name="<?php echo $this->app; ?>[menu_title]" value="<?php echo esc_attr( $current['menu_title'] ); ?>" /></td>
		</tr>

		<tr valign="top">
		<th scope="row">License Code</th>
		<td>
			<input type="text" name="<?php echo $this->app; ?>[license_code]" value="<?php echo esc_attr( $current['license_code'] ); ?>" />
			<?php if( 1 && strlen($license_status_view) ) : ?>
				<div style="margin: 1em 0;" id="hc-license-status2">
					<?php echo $license_status_view; ?>
				</div>
			<?php endif; ?>
			<?php if( 0 && strlen($current['license_code']) ) : ?>
				<div style="margin: 1em 0;" id="hc-license-status">
					Checking license ...
				</div>
			<?php endif; ?>
		</td>
		</tr>

		<tr valign="top">
		<th scope="row">&nbsp;</th>
		<td>
			<input name="<?php echo $this->app; ?>_submit" type="submit" class="button-primary" value="Save" />
		</td>
		</tr>

	</table>
</form>
</div>

<?php if( 0 && strlen($current['license_code']) ) : ?>
<script>
jQuery(document).ready( function()
{
	jQuery.getScript( "<?php echo $check_url; ?>" )
		.done( function(script, textStatus)
		{
			var display_this = "<div class=\"";
			display_this += "\"";

			if( ntsLicenseStatus ){
				display_this += " style=\"border: #090 1px solid;\"";
			}
			else {
				display_this += " style=\"border: #900 1px solid;\"";
			}

			display_this += ">";
			display_this += ntsLicenseText;
			display_this += "</div>";

			jQuery('#hc-license-status').html( display_this );
		})
		.fail( function(jqxhr, settings, exception)
		{
			alert( "Error connecting to the license server" );
			// alert(arguments[1].toString());
			// alert(arguments[2].toString());
		});
});
</script>
<?php endif; ?>

<?php
	}
}
}
?>