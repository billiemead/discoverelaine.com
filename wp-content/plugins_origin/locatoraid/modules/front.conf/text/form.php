<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Front_Conf_Text_Form_LC_HC_MVC
{
	public function inputs()
	{
		$return = array(
			'front_text:submit_button'	=> array(
				'input'		=> $this->app->make('/form/text'),
				'label'		=> HCM::__('Submit Button'),
				'validators' => array(
					$this->app->make('/validate/required'),
					),
				'help'		=> HCM::__('Search'),
				),

			'front_text:search_field'	=> array(
				'input'		=> $this->app->make('/form/text'),
				'label'		=> HCM::__('Search Field'),
				'validators' => array(
					$this->app->make('/validate/required'),
					),
				'help'		=> HCM::__('Address or Zip Code'),
				),

			'front_text:more_results'	=> array(
				'input'		=> $this->app->make('/form/text'),
				'label'		=> HCM::__('More Results Link'),
				'validators' => array(
					$this->app->make('/validate/required'),
					),
				'help'		=> HCM::__('More Results'),
				),

			'front_text:no_results'	=> array(
				'input'		=> $this->app->make('/form/textarea'),
				'label'		=> HCM::__('No Results'),
				'validators' => array(
					$this->app->make('/validate/required'),
					),
				'help'		=> HCM::__('No Results'),
				),

			'front_text:locate_me'	=> array(
				'input'		=> $this->app->make('/form/text'),
				'label'		=> HCM::__('Locate Me'),
				'validators' => array(
					$this->app->make('/validate/required'),
					),
				'help'		=> HCM::__('Locate Me'),
				),

			'front_text:my_location'	=> array(
				'input'		=> $this->app->make('/form/text'),
				'label'		=> HCM::__('My Location'),
				'validators' => array(
					$this->app->make('/validate/required'),
					),
				'help'		=> HCM::__('My Location'),
				),

			'front_text:reset_my_location'	=> array(
				'input'		=> $this->app->make('/form/text'),
				'label'		=> HCM::__('Reset My Location'),
				'validators' => array(
					$this->app->make('/validate/required'),
					),
				'help'		=> HCM::__('Reset'),
				),
		);

		return $return;
	}
}