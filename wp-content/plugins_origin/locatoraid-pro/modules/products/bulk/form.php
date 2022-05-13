<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Bulk_Form_LC_HC_MVC
{
	public function inputs()
	{
		$options = array(
			''			=> HCM::__('Bulk Actions'),
			'delete'	=> HCM::__('Delete'),
			'order'	=> HCM::__('Update Show Order'),
			);

		$return = array(
			'action'	=> array(
				'input'	=> $this->app->make('/form/select')
					->set_options( $options ),
				'validators' => array(
					$this->app->make('/validate/required')
					),
				),

			'id'	=> array(
				'input'	=> $this->app->make('/form/checkbox-set'),
				'validators' => array(
					// $this->app->make('/validate/required')
					),
				),

			);

		$entries = $this->app->make('/products/commands/read')
			->execute()
			;

		foreach( $entries as $e ){
			$return[ 'show_order_' . $e['id'] ] = $this->app->make('/form/text');
		}

		return $return;
	}
}