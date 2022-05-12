<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Locations_Custom_Fields_Migration_1_LC_HC_MVC
{
	public function up()
	{
		if( $this->app->db->field_exists('misc1', 'locations') ){
			return;
		}

		$dbforge = $this->app->db->dbforge();

		for( $ii = 1; $ii <= 10; $ii++ ){
			$dbforge->add_column(
				'locations',
				array(
					'misc' . $ii => array(
						'type'	=> 'TEXT',
						'null'	=> TRUE,
						),
					)
				);
		}
	}
}