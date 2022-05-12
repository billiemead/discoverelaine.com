<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Import_Form_LC_HC_MVC
{
	public function inputs()
	{
		$mode_options = array(
			'append'	=> HCM::__('Append To Current Locations'),
			'overwrite'	=> HCM::__('Delete Current Locations'),
			);

		$return = array(
			'mode'	=> array(
				'input'	=> $this->app->make('/form/radio')
					->set_options( $mode_options ),
				),

			'userfile'	=> array(
				'input' => $this->app->make('/form/file'),
				'label'	=> HCM::__('.CSV Only'),
				'validators' => array(
					$this->app->make('/validate/required')
					)
				),

			'core:csv_separator' => array(
				'input'	=> $this->app->make('/form/select')
					->set_options( 
						array(
							','	=> ',',
							';'	=> ';',
							)
						),
				'label'	=> HCM::__('CSV Delimiter'),
				),
			);

		return $return;
	}
}