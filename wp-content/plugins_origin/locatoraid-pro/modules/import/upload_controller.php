<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Import_Upload_Controller_LC_HC_MVC
{
	public function execute()
	{
		set_time_limit(1500);

		$settings = $this->app->make('/app/settings');

		$post = $this->app->make('/input/lib')->post();

		$inputs = $this->app->make('/import/form')
			->inputs()
			;
		$helper = $this->app->make('/form/helper');

		list( $this_form_values, $errors ) = $helper->grab( $inputs, $post );

		$separator = $this_form_values['core:csv_separator'];
		if( ! strlen($separator) ){
			$separator = ',';
		}
		$oldSeparator = $settings->get('core:csv_separator');

		if( $oldSeparator != $separator ){
			$values['core:csv_separator'] = $separator;
			$response = $this->app->make('/conf/commands/update')
				->execute( $values )
				;
		}

		// $separator = $settings->get('core:csv_separator');

		$presenter = $this->app->make('/import/presenter');
		$fields = $presenter->fields();
		list( $mandatory_fields, $other_fields ) = $fields;

		// if any of the other fields contain * star
		$has_stars = array();
		reset( $other_fields );
		foreach( $other_fields as $fn ){
			if( strpos($fn, '*') !== FALSE ){
				$has_stars[ $fn ] = '/^' . str_replace('*', '.*', $fn) . '$/i';
			}
		}

		if( $errors ){
			return $this->app->make('/http/view/response')
				->set_redirect('-referrer-') 
				;
		}

		$mode = $this_form_values['mode'];
		$checkduplicates = isset($this_form_values['checkduplicates']) ? $this_form_values['checkduplicates'] : FALSE;

		$tmp_name = $this_form_values['userfile']['tmp_name'];

		$parse_error = FALSE;

	// to handle mac created files
		ini_set( 'auto_detect_line_endings', TRUE );

		$handle = fopen($tmp_name, "r");
		if( $handle === FALSE ){
			$errors = array(
				'userfile'	=> HCM::__('Can not open the uploaded file')
				);

			$session = $this->app->make('/session/lib');
			$session
				->set_flashdata('error', $errors)
				;
			return $this->app->make('/http/view/response')
				->set_redirect('-referrer-') 
				;
		}

		$line_no = 0;
		setlocale( LC_ALL, "en_US.UTF-8" );

	// first line
		$line = fgetcsv($handle, 10000, $separator);

		if( ! $line ){
			$errors = array(
				'userfile'	=> HCM::__('Empty file')
				);

			$session = $this->app->make('/session/lib');
			$session
				->set_flashdata('error', $errors)
				;
			return $this->app->make('/http/view/response')
				->set_redirect('-referrer-') 
				;
		}

	// parse titles
		$prop_names = array();
		for( $ii = 0; $ii < count($line); $ii++ ){
			$this_pname = $line[$ii];

			if( ! $ii ){
				//check BOM for first line
				$bom = pack("CCC", 0xef, 0xbb, 0xbf);
				if( 0 == strncmp($this_pname, $bom, 3) ){
					// BOM detected
					$this_pname = substr($this_pname, 3);
				}
			}

			$this_pname = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $this_pname);
			$this_pname = trim( $this_pname );
			$this_pname = trim( $this_pname, '"' );

			if( strpos($this_pname, ':') === FALSE ){
				$this_pname = strtolower($this_pname);
			}

			$prop_names[$ii] = $this_pname;
		}

	// check for mandatory fields
		$missing_fields = array();
		$skipping_fields = array();

		reset( $mandatory_fields );
		foreach( $mandatory_fields as $f ){
			if( ! in_array($f, $prop_names) ){
				$missing_fields[] = $f;
			}
		}

		if( $missing_fields ){
			$errors = array(
				'userfile'	=> HCM::__('Mandatory Fields Missing') . ': ' . join(', ', $missing_fields)
				);

			$session = $this->app->make('/session/lib');
			$session
				->set_flashdata('error', $errors)
				;
			return $this->app->make('/http/view/response')
				->set_redirect('-referrer-') 
				;
		}

		foreach( $prop_names as $f ){
			if( ! (in_array($f, $mandatory_fields) OR in_array($f, $other_fields)) ){
				$skip_this = TRUE;
			// if any of the other fields contain * star
				if( $has_stars ){
					reset( $has_stars );
					foreach( $has_stars as $fn => $fre ){
						if( preg_match($fre, $f) ){
							$skip_this = FALSE;
							break;
						}
					}
				}

				if( $skip_this ){
					$skipping_fields[] = $f;
				}
				else {
					if( ! in_array($f, $other_fields) ){
						$other_fields[] = $f;
					}
				}
			}
		}

		$my_fields = array_merge($mandatory_fields, $other_fields);

// NOW GET THE LINES
		$data = array();
		$prop_count = count($prop_names);

		while( ($line = fgetcsv($handle, 10000, $separator)) !== FALSE ){
			$values = array();
			for( $i = 0; $i < $prop_count; $i++ ){

				$check_name = $prop_names[$i];
				if( strpos($check_name, ':') === FALSE ){
					$check_name = strtolower($check_name);
				}
				if( in_array($check_name, $my_fields) ){
					if( isset($line[$i]) ){
						$values[ $check_name ] = $line[$i];
					}
					else {
						$values[ $check_name ] = '';
					}
				}
			}

		// convert to UTF
			$keys = array_keys($values);
			foreach( $keys as $k ){
				if( ! hc2_seems_utf8($values[$k]) ){
					$values[$k] = utf8_encode($values[$k]);
				}
			}

		// additionally check required fields
			$ok = TRUE;
			reset( $mandatory_fields );
			foreach( $mandatory_fields as $mf ){
				if( ! strlen(trim($values[$mf])) ){
					if( $mf == 'street1' ){
						// check street2
						if( isset($values['street2']) ){
							if( $street2 = strlen(trim($values['street2'])) ){
								$values['street1'] = $values['street2'];
								$values['street2'] = '';
							}
						}
						continue;
					}
// echo "SKIP AS DATA MISSING FOR FIELD '$mf' FOR LINE " . join(',', $line) . "<br>";
// _print_r( $values );
					$ok = FALSE;
					break;
				}
			}

			if( array_key_exists('latitude', $values) && (! $values['latitude']) ){
				unset( $values['latitude'] );
			}
			if( array_key_exists('longitude', $values) && (! $values['longitude']) ){
				unset( $values['longitude'] );
			}

			if( $ok ){
				$data[] = $values;
			}
		}

	// check if we delete current locations
		switch( $this_form_values['mode'] ){
			case 'overwrite':
				$q = $this->app->db->query_builder();
				$q->where(1, 1);
				$sql = $q->get_compiled_delete('locations');
				$this->app->db->query( $sql );
				break;
		}

		$result_count = $this
			->import($data)
			;

// $this->app->profiler()->mark('controller_end');
// if( isset($GLOBALS['wpdb']) ){
	// _print_r( $GLOBALS['wpdb']->queries );
	// $q_time = 0;
	// foreach( $GLOBALS['wpdb']->queries as $q ){
		// $q_time += $q[1];
	// }
	// echo "TOTAL SQL TIME: $q_time<br>";
// }
// echo $this->app->profiler()->run();
// exit;

		$msgbus = $this->app->make('/msgbus/lib');

		// $msg = HCM::__('Locations imported') . ': ' . $result_count;
		// $msgbus->add('message', $msg);

		if( $skipping_fields ){
			$warning = HCM::__('Fields not recognized') . ':<br/>' . join(', ', $skipping_fields);
			$msgbus->add('warning', $warning);
		}

		$redirect_to = $this->app->make('/http/uri')
			->url('/locations')
			;
		return $this->app->make('/http/view/response')
			->set_redirect($redirect_to) 
			;
	}

	public function import( $data )
	{
		$cm = $this->app->make('/commands/manager');
		$command = $this->app->make('/locations/commands/create');
		$count = 0;

		foreach( $data as $e ){
			$command->execute( $e );

			$response = $cm->results( $command );

			if( $response && is_array($response) && isset($response['id']) && $response['id'] ){
				$count++;
			}
		}

		return $count;
	}
}