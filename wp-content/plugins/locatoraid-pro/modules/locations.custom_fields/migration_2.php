<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Locations_Custom_Fields_Migration_2_LC_HC_MVC
{
	public function up()
	{
		$dbforge = $this->app->db->dbforge();

		for( $ii = 1; $ii <= 10; $ii++ ){
			if( $this->app->db->field_exists('misc' . $ii, 'locations') ){
				continue;
			}

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