<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
global $wpdb;
$shortcode = '' . $this->app . '';
$pages = array();
$pages = $wpdb->get_results( 
	"
	SELECT 
		ID 
	FROM $wpdb->posts 
	WHERE 
		( post_type = 'post' OR post_type = 'page' ) 
		AND 
		( post_content LIKE '%[" . $shortcode . "%]%' )
		AND 
		( post_status = 'publish' )
	"
	);

$pages_options = array();
foreach( $pages as $page ){
	$permalink = get_permalink($page->ID);
	$pages_options[ $permalink ] = $permalink;
}
$default_locator_page = NULL;
if( $pages ){
	$default_locator_page = $permalink;
}

$label = isset($instance['label']) ? $instance['label'] : __('Address or Zip Code', $this->app);
$btn = isset($instance['btn']) ? $instance['btn'] : __('Search', $this->app);
$target = isset($instance['target']) ? $instance['target'] : $default_locator_page;
?>
<p>
	<label for="<?php echo $this->get_field_name('label'); ?>"><?php echo __('Title', $this->app); ?>:</label>
	<input type="text" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo $label; ?>">
</p>

<p>
	<label for="<?php echo $this->get_field_name('btn'); ?>"><?php echo __('Button Text', $this->app); ?>:</label>
	<input type="text" name="<?php echo $this->get_field_name('btn'); ?>" value="<?php echo $btn; ?>">
</p>

<?php if( count($pages_options) > 1 ) : ?>
<p>
	<label for="<?php echo $this->get_field_name('target'); ?>"><?php echo __('Target Page', $this->app); ?>:</label>
	<select name="<?php echo $this->get_field_name('target'); ?>">
	<?php foreach($pages_options as $pk => $pv) : ?>
		<option value="<?php echo $pk; ?>"<?php if($pk == $target){echo ' selected';}?>><?php echo $pv; ?></option>
	<?php endforeach; ?>
	</select>
</p>
<?php endif; ?>
