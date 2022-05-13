<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Locations_Products_Presenter_LC_HC_MVC
{
	public function present_products( $data )
	{
		$return = '-';

		$products = isset($data['product']) ? $data['product'] : NULL;
		if( ! ( $products && is_array($products) ) ){
			return $return;
		}

		$return = array();
		foreach( $products as $e ){
			$return[] = $e['title'];
		}

		$return = join(', ', $return);
		return $return;
	}
}