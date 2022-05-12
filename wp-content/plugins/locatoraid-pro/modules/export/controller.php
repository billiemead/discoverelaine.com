<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Export_Controller_LC_HC_MVC
{
	public function execute()
	{
		$command_args = array(
			array('with', '-all-')
			);
		$entries = $this->app->make('/locations/commands/read')
			->execute( $command_args )
			;

		if( ! $entries ){
			echo 'none';
			exit;
		}

		$settings = $this->app->make('/app/settings');
		$separator = $settings->get('core:csv_separator');
		if( ! strlen($separator) ){
			$separator = ',';
		}

		$data = array();

		$p = $this->app->make('/export/presenter');
		$fields = $p->fields();

		$header_data = hc2_build_csv( $fields, $separator );
		$data[] = $header_data;

		foreach( $entries as $e ){
			$e = $p->export($e);

			$this_data = array();
			reset( $fields );
			foreach( $fields as $k ){
				$v = isset($e[$k]) ? $e[$k] : NULL;
				$this_data[] = $v;
			}
			$this_data = hc2_build_csv( $this_data, $separator );

			$data[] = $this_data;
		}

// $return = '';
// foreach( $data as $line ){
	// $return .= $line . '<br>';
// }
// return $return;

		$out = $this->app->make('/http/lib/download');

		$file_name = 'export';
		$file_name .= '-' . date('Y-m-d_H-i') . '.csv';

		$data = join("\n", $data);
		$out->download( $file_name, $data );
		exit;
		// return $view;
	}
}