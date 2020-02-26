<?php

/**
 * LeasePress
 *
 * @package   LeasePress
 * @author    Erik Ruhling <ecruhling@gmail.com>
 * @copyright Resource Branding and Design
 * @license   GPL 2.0+
 * @link      https://resourceatlanta.com
 */


/**
 * This class is where all the API lookups happen
 */
class LP_API_Lookups extends LP_Base {

	/**
	 * Checks if file contains valid JSON
	 *
	 * @param $json
	 *
	 * @return bool
	 */
	private function is_JSON( $json ) {
		json_decode( $json );

		return ( json_last_error() === JSON_ERROR_NONE );
	}

	/**
	 * Gets the contents of a file if it exists, otherwise grabs and caches
	 *
	 * @param string $file
	 * @param string $methodName
	 * @param int $hours
	 *
	 * @return bool|string
	 */
	private function get_content( $file, $methodName, $hours = 24 ) {

		$current_time = time();
		$expire_time  = $hours * 60 * 60;

		if ( file_exists( $file ) && ( $current_time - $expire_time < filemtime( $file ) ) ) {

			return file_get_contents( $file ); // get contents if file has not expired

		} else {

			$content = $this->get_rentcafe_data( $methodName );

			if ( $this->is_JSON( $content ) ) {
				file_put_contents( $file, $content ); // write contents if file expired

				return $content;

			} else {
				// not valid JSON - use old file
				return file_get_contents( $file ); // get contents of file; not valid JSON
			}

		}
	}

	/**
	 * Get RENTCafe data
	 *
	 * @param string $methodName 'floorplan' or 'apartmentavailability' requestType
	 * @param null $type    applicantLogin, residentLogin, availability, and propertyDetailPage
	 *
	 * @return array
	 */
	public static function get_rentcafe_data( $methodName, $type = null ) {

		// set variables
		$settings               = lp_get_settings();
		$rentcafe_api_token     = array_key_exists( 'lp_rentcafe_api_token', $settings ) ? $settings['lp_rentcafe_api_token'] : null;
		$rentcafe_property_id   = array_key_exists( 'lp_rentcafe_property_id', $settings ) ? $settings['lp_rentcafe_property_id'] : null;
		$rentcafe_property_code = array_key_exists( 'lp_rentcafe_property_code', $settings ) ? $settings['lp_rentcafe_property_code'] : null;
		if ( $rentcafe_property_id ) {
			$url           = 'https://api.rentcafe.com/rentcafeapi.aspx?requestType=%s&APIToken=%s&propertyId=%s';
			$json_data_url = sprintf( $url, $methodName, $rentcafe_api_token, $rentcafe_property_id );
		} else {
			$url           = 'https://api.rentcafe.com/rentcafeapi.aspx?requestType=%s&APIToken=%s&propertyCode=%s';
			$json_data_url = sprintf( $url, $methodName, $rentcafe_api_token, $rentcafe_property_code );
		}
		if ($type) {
			$json_data_url = $json_data_url . '&type=' . $type;
		}

		$args = array( 'timeout' => 120 );

		return [ $json_data_url, wp_remote_get( $json_data_url, $args ) ];

	}

	/**
	 * Get Entrata JSON
	 *
	 * @param string $methodName 'getUnitsAvailabilityAndPricing' or 'getUnitTypes'
	 *
	 * @return bool|string
	 */
	private function get_entrata_data( $methodName ) {

		// set variables
		$authentication = base64_encode( get_theme_mod( 'entrata_username_setting' ) . ':' . get_theme_mod( 'entrata_password_setting' ) );
		$url            = 'https://' . get_theme_mod( 'entrata_domain_setting' ) . '.entrata.com/api/v1/propertyunits';
		$propertyID     = get_theme_mod( 'entrata_id_setting' );
		$jsonRequest    = '{
                        "auth": {
                            "type" : "basic"
                        },
                        "requestId" : 15,
                        "method": {
                            "name": ' . json_encode( $methodName ) . ',
                            "version":"r1",
                            "params": {
                                "propertyId" : ' . json_encode( $propertyID ) . ',
                                "availableUnitsOnly" : "0",
                                "unavailableUnitsOnly" : "0",
                                "skipPricing" : "0",
                                "showChildProperties" : "0",
                                "includeDisabledFloorplans" : "0",
                                "includeDisabledUnits" : "0",
                                "showUnitSpaces" : "0",
                                "useSpaceConfiguration" : "0",
                                "allowLeaseExpirationOverride" : "0"
                            }
                        }
                    }';

		// init CURL resource
		$resCurl = curl_init();

		// JSON request setup
		curl_setopt( $resCurl, CURLOPT_HTTPHEADER, array(
			'Content-type: APPLICATION/JSON; CHARSET=UTF-8',
			'Authorization: Basic ' . $authentication
		) );
		curl_setopt( $resCurl, CURLOPT_POSTFIELDS, $jsonRequest );
		curl_setopt( $resCurl, CURLOPT_POST, true );
		curl_setopt( $resCurl, CURLOPT_URL, $url );
		curl_setopt( $resCurl, CURLOPT_RETURNTRANSFER, 1 );

		$result = curl_exec( $resCurl );

		if ( false === $result ) {
			$result = 'Curl error: ' . curl_error( $resCurl );
			curl_close( $resCurl );
		} else {
			curl_close( $resCurl );
		}

		return $result;
	}

	/**
	 * Get The SVGs and PDFs for the plans
	 *
	 * @param $searchFor
	 *
	 * @return array
	 */
	private function get_svgs_pdfs( $searchFor ) {

		$pdf = null;
		$svg = null;

		// use the $name to search for files that match
		$search_query['s']           = $searchFor;
		$search_query['post_status'] = array(
			'publish',
			'inherit'
		);
		$search_query['exact']       = true;
		$search                      = new WP_Query( $search_query );

		if ( $search->have_posts() ) :
			while ( $search->have_posts() ) : $search->the_post();
				$file      = get_the_guid();
				$extension = substr( strrchr( $file, '.' ), 1 );
				if ( $extension == 'pdf' ) : // use first file matching pdf
					$pdf = $file;
				endif;
				if ( $extension == 'svg' ) : // use first file matching svg
					$svg = $file;
				endif;
			endwhile;
			wp_reset_postdata();
		endif;

		return [ $pdf, $svg ];
	}

	/**
	 * $floorplan_types
	 *
	 * @return array of objects
	 *
	 */
	public function floorplanTypes() {

		$floorplansData = [];

		$floorplansArray = json_decode( $this->get_rentcafe_data( 'floorplan' ) );
//		$floorplansArray = json_decode( $this->get_content( 'api_floorplans.json', 'floorplan', 1 ) );
		if ( isset( $floorplansArray[0]->Error ) ) { // if an Error in API request
			return $floorplansData;
		}

		// data for unit types
		foreach ( $floorplansArray as $unit_type ) :

			$baths = substr( $unit_type->Baths, 0, - 1 ); // truncate last '0' from Baths
			$baths = rtrim( $baths, '.0' );; // if there is still a decimal and a zero, remove that. half baths are retained
			$name = strtolower( ltrim( $unit_type->UnitTypeMapping, "61073" ) ); // trim '61073' off unit type name

			// map some of the UnitTypeMapping values to correct names of SVG / PDF files
			// since some of the UnitTypeMapping values have 'e' or 'w' for East & West
			// and there are no differences between these as far as SVG / PDF files are concerned
			// also some of the plans at RentCAFE do not exist as SVG / PDF files, so in that case map
			// this to an existing plan

			$name = rtrim( $name, "w" ); // trim 'w' off in case it is a 'West' UnitTypeMapping
			$name = rtrim( $name, "e" ); // trim 'e' off in case it is a 'East' UnitTypeMapping

			switch ( $name ) {
				case 'b1': // SVG / PDF for plan B1 does not exist
					$name = 'b2'; // use B2 instead
					break;
				case 'c2': // SVG / PDF for plan C2 does not exist
					$name = 'c'; // use C instead
					break;
				case 'd2': // SVG / PDF for plan D2 does not exist
					$name = 'd'; // use D instead
					break;
				case 'f2': // SVG / PDF for plan F2 does not exist
					$name = 'f3'; // use F3 instead
					break;
				case 'j1': // SVG / PDF for plan J1 does not exist
					$name = 'j'; // use J instead
					break;
				case 'r1': // SVG / PDF for plan R1 does not exist
					$name = 'r2'; // use R2 instead
					break;
				case 's': // SVG / PDF for plan S does not exist
					$name = 'a3'; // use A3 instead
					break;
			}

			[
				$pdf,
				$svg
			] = $this->get_svgs_pdfs( $name ); // use $name to search for similar named SVGs and PDFs
			$unit_type->Name         = $name; // add correct 'Name' to object
			$unit_type->Baths        = $baths; // change Baths to a nicer number
			$unit_type->FloorplanPDF = $pdf;
			$unit_type->FloorplanSVG = $svg;
			$floorplansData[]        = $unit_type;

		endforeach;

		return $floorplansData;

	}

	/**
	 * $unit_availabilities
	 *
	 * @return array of objects
	 *
	 */
	public function unitAvailabilities() {

		$availabilityData = [];

		$availabilityArray = json_decode( $this->get_content( 'api_availabilities.json', 'apartmentavailability', 1 ) );

		if ( isset( $availabilityArray[0]->Error ) ) { // if an Error in API request
			return $availabilityData;
		}

		$unit_types = LP_API_Lookups::floorplanTypes(); // create a unit_types array in order to get the extra data for the units (name, PDF, SVGs)

		// data for unit availabilities
		foreach ( $availabilityArray as $unit ) :
			$key        = array_search( $unit->FloorplanName, array_column( $unit_types, 'FloorplanName' ) ); // search unit_types array for key containing the same FloorplanName
			$unit->Name = $unit_types[ $key ]->Name; // add correct 'Name' to object
			$baths      = substr( $unit->Baths, 0, - 1 ); // truncate last '0' from Baths
			$baths      = rtrim( $baths, '.0' );; // if there is still a decimal and a zero, remove that. half baths are retained
			$unit->FloorplanPDF = $unit_types[ $key ]->FloorplanPDF; // use key to access unit_types array to get PDF
			$unit->FloorplanSVG = $unit_types[ $key ]->FloorplanSVG; // use key to access unit_types array to get SVG
			$unit->Baths        = $baths; // change Baths to a nicer number
			$unit->Floor        = substr( $unit->ApartmentName, 0, 2 );;
			$sortPrice = intval( $unit->MaximumRent ); // get price of this unit

			switch ( true ) { // use price to create a Price Range
				case in_array( $sortPrice, range( 1000, 1499 ) ):
					$sortPrice = (string) '1000-1499';
					break;
				case in_array( $sortPrice, range( 1500, 1999 ) ):
					$sortPrice = (string) '1500-1999';
					break;
				case in_array( $sortPrice, range( 2000, 2499 ) ):
					$sortPrice = (string) '2000-2499';
					break;
				case in_array( $sortPrice, range( 2500, 2999 ) ):
					$sortPrice = (string) '2500-2999';
					break;
				case in_array( $sortPrice, range( 3000, 3499 ) ):
					$sortPrice = (string) '3000-3499';
					break;
				case $sortPrice > 3500:
					$sortPrice = (string) '3500+';
					break;
			}

			$unit->PriceRange = $sortPrice; // add Price Range

			$availabilityData[] = $unit;

		endforeach;

		return $availabilityData;

	}

}
