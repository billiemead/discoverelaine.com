<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Migration_1_LC_HC_MVC
{
	public function up()
	{
		if( $this->app->db->table_exists('products') ){
			return;
		}

		$dbforge = $this->app->db->dbforge();

		$dbforge->add_field(
			array(
				'id' => array(
					'type' => 'INT',
					'null' => FALSE,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
					),
				'title' => array(
					'type' => 'VARCHAR(255)',
					'null' => FALSE,
					),
				)
			);
		$dbforge->add_key('id', TRUE);
		$dbforge->create_table('products');

	// import from old Locatoraid version
		if( ! $this->app->db->field_exists('products', 'locations') ){
			return;
		}

		$q = $this->app->db->query_builder();

		$q->select('products');
		$sql = $q->get_compiled_select('locations');
		$results = $this->app->db->query( $sql );

		$existing_products = array();
		$insert = array();
		foreach( $results as $row ){
			$this_e = $row['products'];
			$this_products = explode(',', $this_e);
			reset( $this_products );
			foreach( $this_products as $this_product ){
				$this_product = trim( $this_product );
				if( strlen($this_product) ){
					$existing_products[ $this_product ] = $this_product;
				}
			}
		}

		foreach( $existing_products as $p ){
			$insert = array(
				'title'	=> $p,
				);
			$this->app->db->insert('products', $insert);
		}
	}
}