<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Import_Presenter_LC_HC_MVC
{
	public function fields()
	{
		$fields = array( 
			array( 'name' ),
			array( 'street1', 'street2', 'city', 'state', 'zip', 'country', 'phone', 'website', 'latitude', 'longitude', 'id' ),
			);

		$fields = $this->app
			->after( array($this, __FUNCTION__), $fields )
			;

	// final fields
		$always = array('street1', 'street2', 'city', 'state', 'zip', 'country', 'latitude', 'longitude', 'id');

		$app_settings = $this->app->make('/app/settings');
		$return = array( array(), array() );

		foreach( $fields[0] as $k ){
			if( ! in_array($k, $always) ){
				$k2 = $k;
				if( substr($k2, -2) == ':*' ){
					$k2 = substr($k2, 0, -2);
				}
				$this_pname = 'fields:' . $k2 . ':use';
				$this_pname_config = $app_settings->get($this_pname);
				if( ! $this_pname_config ){
					continue;
				}
			}

			$return[0][] = $k;
		}

		foreach( $fields[1] as $k ){
			if( ! in_array($k, $always) ){
				$k2 = $k;
				if( substr($k2, -2) == ':*' ){
					$k2 = substr($k2, 0, -2);
				}
				$this_pname = 'fields:' . $k2 . ':use';
				$this_pname_config = $app_settings->get($this_pname);
				if( ! $this_pname_config ){
					continue;
				}
			}
			$return[1][] = $k;
		}
	
		return $return;
	}
}