<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Locations_Bulk_Form_LC_HC_MVC
{
	public function inputs()
	{
		$options = array(
			''					=> HCM::__('Bulk Actions'),
			'priority_normal'		=> HCM::__('Priority') . ': ' . HCM::__('Normal'),
			'priority_featured'	=> HCM::__('Priority') . ': ' . HCM::__('Featured'),
			'priority_draft'		=> HCM::__('Priority') . ': ' . HCM::__('Draft'),
			'resetcoord'	=> HCM::__('Reset Coordinates'),
			'delete'			=> HCM::__('Delete'),
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

		return $return;
	}
}