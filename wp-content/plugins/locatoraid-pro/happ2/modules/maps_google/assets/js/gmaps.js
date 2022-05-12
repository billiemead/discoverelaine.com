document.addEventListener('DOMContentLoaded', function()
{
	var this_js_url = '//maps.googleapis.com/maps/api/js';

	var api_key = hc2_gmaps_vars['api_key'];
	if( api_key ){
		this_js_url += '?&key=' + api_key;
		if( hc2_gmaps_vars.hasOwnProperty('language') ){
			var lang = hc2_gmaps_vars['language'];
			if( lang.length ){
				this_js_url += '&language=' + lang;
			}
		}
	}

	if( (typeof google === 'object') && (typeof google.maps === 'object') ){
		jQuery(document).trigger('hc2-gmaps-loaded');
		return;
	}
	else {
		jQuery.getScript( this_js_url, function() {
			jQuery(document).trigger('hc2-gmaps-loaded');
		});
	}
});

function hc2_init_gmaps( map_div )
{
	var scrollwheel = true;
	if( hc2_gmaps_vars.hasOwnProperty('scrollwheel') && (! hc2_gmaps_vars['scrollwheel']) ){
		scrollwheel = false;
	}

	var map = new google.maps.Map( 
		document.getElementById(map_div), {
			zoom: 12,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: scrollwheel
		}
	);

	var map_style = hc2_gmaps_vars['map_style'];
	if( map_style.length ){
		var valid_style = hc2_try_parse_json( map_style );
		if( valid_style ){
			map.setOptions({ styles: valid_style });
		}
	}

	var more_options = hc2_gmaps_vars['more_options'];
	if( more_options.length ){
		var valid_options = hc2_try_parse_json( more_options );
		if( valid_options ){
			// console.log( valid_options );
			map.setOptions( valid_options );
		}
		else {
			console.log( 'bad map options' );
		}
	}

	return map;
}

function hc2_geocode( address, callback ){
	if( 'undefined' == typeof hc2_geocode.cache ){
		hc2_geocode.cache = {};
	}

	if( typeof address == 'string' ){
		address = { 'address': address };
	}

	var more_pass_args = [];
	if( arguments.length > 2 ){
		for( var ii = 2; ii < arguments.length; ii++ ){
			more_pass_args.push( arguments[ii] );
		}
	}

	if( hc2_geocode.cache.hasOwnProperty(address.address) ){
		var results = {
			lat: hc2_geocode.cache[address.address][0],
			lng: hc2_geocode.cache[address.address][1],
			};

		var pass_args = [ true, results, google.maps.GeocoderStatus.OK ];
		pass_args = pass_args.concat( more_pass_args );
		callback.apply( this, pass_args );
// console.log( 'GEOCODER CACHE: ' + address.address + ': ' + hc2_geocode.cache[address.address][0] + ', ' + hc2_geocode.cache[address.address][1] );
		return true;
	}

	if( ! ((typeof google === 'object') && (typeof google.maps === 'object')) ){
		var is_success = false;
		var status = 0;
		var msg = 'Google Maps Not Loaded!';
		// callback( is_success, msg, status );
		var pass_args = [is_success, msg, status];
		pass_args = pass_args.concat( more_pass_args );
		callback.apply( this, pass_args );
		return false;
	}

	var geocoder = new google.maps.Geocoder();


	geocoder.geocode(
		// { 'address': address },
		address,
		function( geo_results, status ){
			var is_success = false;
			var results = '';

		// alert( address );
			switch( status ){
				case google.maps.GeocoderStatus.OVER_QUERY_LIMIT :
					results = 'Daily limit reached, please try tomorrow';
					break;

				case google.maps.GeocoderStatus.ZERO_RESULTS:
					results = 'Address not found';
					break;

				case google.maps.GeocoderStatus.OK:
					is_success = true;
					var this_loc = geo_results[0].geometry.location;
					results = {
						lat: this_loc.lat(),
						lng: this_loc.lng(),
						};

					hc2_geocode.cache[ address.address ] = [ results.lat, results.lng ];
					break;

				default :
					results = '' + status;
					if( geo_results["message"] && geo_results["message"].length ){
						results += ', ' + geo_results["message"];
					}
					results += ', ' + 'you may probably need to check your Google Maps API Key';
					break;
			}

		// callback( is_success, results, status );
			var pass_args = [is_success, results, status];
			pass_args = pass_args.concat( more_pass_args );
			callback.apply( this, pass_args );
		}
	);
}
