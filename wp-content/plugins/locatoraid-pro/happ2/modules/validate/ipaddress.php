<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Validate_IpAddress_HC_MVC
{
	protected $msg;

	public function _init()
	{
		$this->msg = HCM::__('This field must contain an IP address.');
		return $this;
	}

	public function validate( $value )
	{
		$return = TRUE;

		$preg = '/^[\*\d]{1,3}\.[\*\d]{1,3}\.[\*\d]{1,3}\.[\*\d]{1,3}$/';

		$return = (bool) preg_match( $preg, $value);
		if( ! $return ){
			$return = $this->msg;
		}
		return $return;
	}
}