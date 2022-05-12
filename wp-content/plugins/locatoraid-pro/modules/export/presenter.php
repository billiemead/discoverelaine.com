<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Export_Presenter_LC_HC_MVC
{
	protected $fields = NULL;

	public function fields()
	{
		$p = $this->app->make('/locations/presenter');
		$fields = $p->database_fields();

		$app_settings = $this->app->make('/app/settings');
		$always = array('name', 'street1', 'street2', 'city', 'state', 'zip', 'country', 'latitude', 'longitude');

		foreach( $fields as $k ){
			if( ! in_array($k, $always) ){
				$k2 = $k;
				if( strpos($k2, ':') !== FALSE ){
					$k22 = explode(':', $k2);
					$k2 = array_shift($k22);
				}
				$this_pname = 'fields:' . $k2 . ':use';
				$this_pname_config = $app_settings->get($this_pname);
				if( ! $this_pname_config ){
					continue;
				}
			}

			$return[] = $k;
		}

		return $return;
	}

	public function export( $data )
	{
		if( $this->fields === NULL ){
			$this->fields = $this->fields();
		}

		$take = $this->fields;
		foreach( $take as $k ){
			$v = isset($data[$k]) ? $data[$k] : NULL;
			$return[ $k ] = $v;
		}

		$return = $this->app
			->after( $this, $return, $data )
			;

		return $return;
	}
}