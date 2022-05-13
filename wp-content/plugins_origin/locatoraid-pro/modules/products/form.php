<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Products_Form_LC_HC_MVC
{
	public function inputs( $current_id = NULL )
	{
		$return = array(
			'title'	=> array(
				'input'	=> $this->app->make('/form/text')
					->set_label( HCM::__('Title') ),
				'validators' => array(
					$this->app->make('/validate/required'),
					$this->app->make('/validate/unique')
						->params( 'products', 'title', $current_id ),
					)
				),
			);

		return $return;
	}
}