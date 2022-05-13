<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Conf_Form_HC_MVC
{
	public function inputs()
	{
		$return = array();

		$return['front:product:select_type'] = array(
			'input'	=> $this->app->make('/form/radio')
				->set_options(
					array(
						'checkbox'	=> HCM::__('Checkbox'),
						'radio'		=> HCM::__('Radio'),
						'none'		=> HCM::__('Do Not Show'),
						)
					)
				,
			'label'	=> HCM::__('Selection Type In Front View'),
			// 'validators'	=> array(
				// $this->app->make('/validate/required')
				// )
			);

		return $return;
	}
}