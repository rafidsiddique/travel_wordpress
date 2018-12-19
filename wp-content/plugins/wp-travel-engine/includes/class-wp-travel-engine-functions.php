<?php
/**
 * Basic functions for the plugin.
 *
 * Maintain a list of functions that are used in the plugin for basic purposes
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes
 * @author    
 */
class Wp_Travel_Engine_Functions
{

	function init()
	{
		add_filter('the_content', array( $this, 'wte_remove_empty_p' ), 20, 1);
		add_filter('term_description', array( $this, 'wte_remove_empty_p' ), 20, 1);
		add_filter( 'pll_get_post_types', array( $this, 'wte_add_cpt_to_pll' ), 10, 2 );
		add_filter( 'pll_get_taxonomies', array( $this,'wte_add_tax_to_pll' ), 10, 2 );
	}
 
	function wte_add_cpt_to_pll( $post_types, $is_settings ) {
	    if ( $is_settings ) {
	        unset( $post_types['my_cpt'] );
	        unset( $post_types['my_cpt1'] );
	        unset( $post_types['my_cpt2'] );
	        unset( $post_types['my_cpt3'] );
	    } else {
	        $post_types['my_cpt'] = 'trip';
	        $post_types['my_cpt1'] = 'booking';
	        $post_types['my_cpt2'] = 'customer';
	        $post_types['my_cpt3'] = 'enquiry';
	    }
	    return $post_types;
	}

 
	function wte_add_tax_to_pll( $taxonomies, $is_settings ) {
	    if ( $is_settings ) {
	        unset( $taxonomies['my_tax'] );
	        unset( $taxonomies['my_tax1'] );
	        unset( $taxonomies['my_tax2'] );
	    } else {
	        $taxonomies['my_tax'] = 'destination';
	        $taxonomies['my_tax1'] = 'activities';
	        $taxonomies['my_tax2'] = 'trip_types';
	    }
	    return $taxonomies;
	}

	//search value in array
	function wp_travel_engine_in_array_r($needle, $haystack, $strict = false) {
	    foreach ($haystack as $item) {
	        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
	            return true;
	        }
	    }

	    return false;
	}

	/**
	* Get Base Currency Code.
	*
	* @return string
	*/
	function wp_travel_engine_currency() {
		$option='';
		$option = get_option( 'wp_travel_engine_settings' );
		$currency_type = $option['currency_code'];
		return apply_filters( 'wp_travel_engine_currency', $currency_type );
	}
	
	function wte_remove_empty_p( $content ) {
	    $content = force_balance_tags( $content );
	    $content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
	    $content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
	    return $content;
	}

	
	/**
	* Get Pagination.
	*
	* @return string
	*/
	function pagination_bar( $custom_query ) {

	    $total_pages = $custom_query->max_num_pages;
	    $big = 999999999; // need an unlikely integer

	    if ($total_pages > 1){
	        $current_page = max(1, get_query_var('paged'));

	        echo paginate_links(array(
	            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	            'format' => '?paged=%#%',
	            'current' => $current_page,
	            'total' => $total_pages,
	        ));
	    }
	}

	function wpte_pagination_option(){
		$pagination_type = get_theme_mod('pagination_type');
		if( $pagination_type == 'pagination_type-radio-numbered' )
		{
			$this->pagination_bar();
		}
		elseif( $pagination_type == 'pagination_type-radio-default' ) {
			echo paginate_links( $args );
			$args = array(
				'base'               => '%_%',
				'format'             => '?paged=%#%',
				'total'              => 1,
				'current'            => 0,
				'show_all'           => false,
				'end_size'           => 1,
				'mid_size'           => 2,
				'prev_next'          => true,
				'prev_text'          => __('« Previous'),
				'next_text'          => __('Next »'),
				'type'               => 'plain',
				'add_args'           => false,
				'add_fragment'       => '',
				'before_page_number' => '',
				'after_page_number'  => ''
			);
		}
	}
	
	/**
	* Get full list of currency codes.
	*
	* @return array
	*/
	function wp_travel_engine_currencies() {
		return array_unique(
			apply_filters( 'wp_travel_engine_currencies',
				array(
					'AED' => __( 'United Arab Emirates Dirham', 'wp-travel-engine' ),
					'ARS' => __( 'Argentine Peso', 'wp-travel-engine' ),
					'AUD' => __( 'Australian Dollars', 'wp-travel-engine' ),
					'BDT' => __( 'Bangladeshi Taka', 'wp-travel-engine' ),
					'BGN' => __( 'Bulgarian Lev', 'wp-travel-engine' ),
					'BRL' => __( 'Brazilian Real', 'wp-travel-engine' ),
					'CAD' => __( 'Canadian Dollars', 'wp-travel-engine' ),
					'CHF' => __( 'Swiss Franc', 'wp-travel-engine' ),
					'CLP' => __( 'Chilean Peso', 'wp-travel-engine' ),
					'CNY' => __( 'Chinese Yuan', 'wp-travel-engine' ),
					'COP' => __( 'Colombian Peso', 'wp-travel-engine' ),
					'CZK' => __( 'Czech Koruna', 'wp-travel-engine' ),
					'DKK' => __( 'Danish Krone', 'wp-travel-engine' ),
					'DOP' => __( 'Dominican Peso', 'wp-travel-engine' ),
					'EGP' => __( 'Egyptian Pound', 'wp-travel-engine' ),
					'EUR' => __( 'Euros', 'wp-travel-engine' ),
					'GBP' => __( 'Pounds Sterling', 'wp-travel-engine' ),
					'HKD' => __( 'Hong Kong Dollar', 'wp-travel-engine' ),
					'HRK' => __( 'Croatia kuna', 'wp-travel-engine' ),
					'HUF' => __( 'Hungarian Forint', 'wp-travel-engine' ),
					'IDR' => __( 'Indonesia Rupiah', 'wp-travel-engine' ),
					'ILS' => __( 'Israeli Shekel', 'wp-travel-engine' ),
					'INR' => __( 'Indian Rupee', 'wp-travel-engine' ),
					'ISK' => __( 'Icelandic krona', 'wp-travel-engine' ),
					'JPY' => __( 'Japanese Yen', 'wp-travel-engine' ),
					'KES' => __( 'Kenyan shilling', 'wp-travel-engine' ),
					'KRW' => __( 'South Korean Won', 'wp-travel-engine' ),
					'LAK' => __( 'Lao Kip', 'wp-travel-engine' ),
					'MXN' => __( 'Mexican Peso', 'wp-travel-engine' ),
					'MYR' => __( 'Malaysian Ringgits', 'wp-travel-engine' ),
					'NGN' => __( 'Nigerian Naira', 'wp-travel-engine' ),
					'NOK' => __( 'Norwegian Krone', 'wp-travel-engine' ),
					'NPR' => __( 'Nepali Rupee', 'wp-travel-engine' ),
					'NZD' => __( 'New Zealand Dollar', 'wp-travel-engine' ),
					'PHP' => __( 'Philippine Pesos', 'wp-travel-engine' ),
					'PKR' => __( 'Pakistani Rupee', 'wp-travel-engine' ),
					'PLN' => __( 'Polish Zloty', 'wp-travel-engine' ),
					'PYG' => __( 'Paraguayan Guaraní', 'wp-travel-engine' ),
					'RON' => __( 'Romanian Leu', 'wp-travel-engine' ),
					'RUB' => __( 'Russian Ruble', 'wp-travel-engine' ),
					'SAR' => __( 'Saudi Riyal', 'wp-travel-engine' ),
					'SEK' => __( 'Swedish Krona', 'wp-travel-engine' ),
					'SGD' => __( 'Singapore Dollar', 'wp-travel-engine' ),
					'THB' => __( 'Thai Baht', 'wp-travel-engine' ),
					'TRY' => __( 'Turkish Lira', 'wp-travel-engine' ),
					'TWD' => __( 'Taiwan New Dollars', 'wp-travel-engine' ),
					'UAH' => __( 'Ukrainian Hryvnia', 'wp-travel-engine' ),
					'USD' => __( 'US Dollars', 'wp-travel-engine' ),
					'VND' => __( 'Vietnamese Dong', 'wp-travel-engine' ),
					'ZAR' => __( 'South African rand', 'wp-travel-engine' ),
					)
				)
			);
	}

	/**
	* Get Currency symbol.
	*
	* @param string $currency (default: '')
	* @return string
	*/
	function wp_travel_engine_currencies_symbol( $currency = '' ) {
		if ( ! $currency ) {
			$currency = $this->wp_travel_engine_currency();
		}

		$symbols = apply_filters( 'wp_travel_engine_currency_symbols', array(
			'AED' => 'د.إ',
			'ARS' => '&#36;',
			'AUD' => '&#36;',
			'BDT' => '&#2547;&nbsp;',
			'BGN' => '&#1083;&#1074;.',
			'BRL' => '&#82;&#36;',
			'CAD' => '&#36;',
			'CHF' => '&#67;&#72;&#70;',
			'CLP' => '&#36;',
			'CNY' => '&yen;',
			'COP' => '&#36;',
			'CZK' => '&#75;&#269;',
			'DKK' => 'DKK',
			'DOP' => 'RD&#36;',
			'EGP' => 'EGP',
			'EUR' => '&euro;',
			'GBP' => '&pound;',
			'HKD' => '&#36;',
			'HRK' => 'Kn',
			'HUF' => '&#70;&#116;',
			'IDR' => 'Rp',
			'ILS' => '&#8362;',
			'INR' => '&#8377;',
			'ISK' => 'Kr.',
			'JPY' => '&yen;',
			'KES' => 'KSh',
			'KRW' => '&#8361;',
			'LAK' => '&#8365;',
			'MXN' => '&#36;',
			'MYR' => '&#82;&#77;',
			'NGN' => '&#8358;',
			'NOK' => '&#107;&#114;',
			'NPR' => '&#8360;',
			'NZD' => '&#36;',
			'PHP' => '&#8369;',
			'PKR' => '&#8360;',
			'PLN' => '&#122;&#322;',
			'PYG' => '&#8370;',
			'RMB' => '&yen;',
			'RON' => 'lei',
			'RUB' => '&#8381;',
			'SAR' => '&#x631;.&#x633;',
			'SEK' => '&#107;&#114;',
			'SGD' => '&#36;',
			'THB' => '&#3647;',
			'TRY' => '&#8378;',
			'TWD' => '&#78;&#84;&#36;',
			'UAH' => '&#8372;',
			'USD' => '&#36;',
			'VND' => '&#8363;',
			'ZAR' => '&#82;',
			) );

		$currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';

		return apply_filters( 'wp_travel_engine_currency_symbol', $currency_symbol, $currency );
	}

	/**
	* Get default settings when no settings are saved
	*
	* @return array of default settings
	*/
	public function wp_travel_engine_get_default_settings() {

		$default_settings = array(
			'currency_code'          => 'USD',
			'price'         => '0.01',
			'charges'          => '50.01',
			);
		$default_settings = apply_filters( 'wp_travel_engine_default_settings', $default_settings );
		return $default_settings;
	}

	/**
	* Get clean special characters free string
	*
	* @return clean string
	*/
	public function wpte_clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		$string = strtolower($string); // Convert to lowercase
		return $string;
	} 
 	
	/**
	* Get field options for trip facts.
	*
	* @return string
	*/
 	function trip_facts_field_options()
	{

		$options = array(
            'text'   	=> 'text',
            'number' 	=> 'number',
            'select' 	=> 'select',
            'textarea' 	=> 'textarea',
            'duration'	=> 'duration',
            );
        $options = apply_filters( 'wp_travel_engine_trip_facts_field_options', $options );
        return $options;
	}

	/**
	* Get options for title while booking trip.
	*
	* @param string $title (default: '')
	* @return string
	*/
 	function order_form_title_options()
	{

		$options = array(
            'Mr'	=>'Mr',
			'Mrs'	=>'Mrs',
			'Ms'	=>'Ms',
			'Miss'	=>'Miss',
			'Other'	=>'Other'
            );
        $options = apply_filters( 'wp_travel_engine_order_form_title_options', $options );
        return $options;
	}

	/**
	* Get default payment method.
	*
	* @param string $options (default: '')
	* @return string
	*/
 	function payment_gateway_options()
	{
		$options = array(
            'paypal_standard'=> 'PayPal Standard',
            'test_payment' 	 => 'Test Payment',
            'amazon' 		 => 'Amazon',
            );
        $options = apply_filters( 'wp_travel_engine_default_payment_gateway_options', $options );
        return $options;
	}

	/**
	* Get field options for place order form.
	*
	*/
 	function wp_travel_engine_place_order_field_options()
	{

		$options = array(
            'text'   		=> 'text',
            'number' 		=> 'number',
            'select' 		=> 'select',
            'textarea' 		=> 'textarea',
            'country-list'	=> 'countrylist',
            'datetime'		=> 'datetime',
            'email'			=> 'email',
            );
        $options = apply_filters( 'wp_travel_engine_place_order_field_options', $options );
        return $options;
	}

	/**
	* Get template options for place order form.
	*
	*/
 	function wp_travel_engine_template_options()
	{

		$options = array(
            'default-template'=> 'default-template',
            );
        $options = apply_filters( 'wp_travel_engine_template_options', $options );
        return $options;
	}

	/**
	* Get formatted cost.
	*
	* @param string $formatted_cost (default: '')
	* @return string
	*/
	function wp_travel_engine_price_format( $cost='' )
	{
		$settings = get_option( 'wp_travel_engine_settings' ); 
		$settings['departure_dates']['decimal_no'] = isset( $settings['departure_dates']['decimal_no'] ) ? esc_attr( $settings['departure_dates']['decimal_no'] ):'2';
		$settings['departure_dates']['separator'] = isset( $settings['departure_dates']['separator'] ) ? esc_attr( $settings['departure_dates']['separator'] ):',';
		$settings['departure_dates']['dec_separator'] = isset( $settings['departure_dates']['dec_separator'] ) ? esc_attr( $settings['departure_dates']['dec_separator'] ):'.';
		$formatted_cost =  number_format( (int)$cost, 0, '', ',' );
		return $formatted_cost;
	}

	/**
	* Get country list for dropdown.
	*
	* @since 1.0.0
	*/
	function wp_travel_engine_country_list()
	{ 
		$options = array(
			"AFG"=>"Afghanistan",
			"ALA"=>"Åland Islands",
			"ALB"=>"Albania",
			"DZA"=>"Algeria",
			"ASM"=>"American Samoa",
			"AND"=>"Andorra",
			"AGO"=>"Angola",
			"AIA"=>"Anguilla",
			"ATA"=>"Antarctica",
			"ATG"=>"Antigua and Barbuda",
			"ARG"=>"Argentina",
			"ARM"=>"Armenia",
			"ABW"=>"Aruba",
			"AUS"=>"Australia",
			"AUT"=>"Austria",
			"AZE"=>"Azerbaijan",
			"BHS"=>"Bahamas",
			"BHR"=>"Bahrain",
			"BGD"=>"Bangladesh",
			"BRB"=>"Barbados",
			"BLR"=>"Belarus",
			"BEL"=>"Belgium",
			"BLZ"=>"Belize",
			"BEN"=>"Benin",
			"BMU"=>"Bermuda",
			"BTN"=>"Bhutan",
			"BOL"=>"Bolivia, Plurinational State of",
			"BES"=>"Bonaire, Sint Eustatius and Saba",
			"BIH"=>"Bosnia and Herzegovina",
			"BWA"=>"Botswana",
			"BVT"=>"Bouvet Island",
			"BRA"=>"Brazil",
			"IOT"=>"British Indian Ocean Territory",
			"BRN"=>"Brunei Darussalam",
			"BGR"=>"Bulgaria",
			"BFA"=>"Burkina Faso",
			"BDI"=>"Burundi",
			"KHM"=>"Cambodia",
			"CMR"=>"Cameroon",
			"CAN"=>"Canada",
			"CPV"=>"Cape Verde",
			"CYM"=>"Cayman Islands",
			"CAF"=>"Central African Republic",
			"TCD"=>"Chad",
			"CHL"=>"Chile",
			"CHN"=>"China",
			"CXR"=>"Christmas Island",
			"CCK"=>"Cocos (Keeling) Islands",
			"COL"=>"Colombia",
			"COM"=>"Comoros",
			"COG"=>"Congo",
			"COD"=>"Congo, the Democratic Republic of the",
			"COK"=>"Cook Islands",
			"CRI"=>"Costa Rica",
			"CIV"=>"Côte d'Ivoire",
			"HRV"=>"Croatia",
			"CUB"=>"Cuba",
			"CUW"=>"Curaçao",
			"CYP"=>"Cyprus",
			"CZE"=>"Czech Republic",
			"DNK"=>"Denmark",
			"DJI"=>"Djibouti",
			"DMA"=>"Dominica",
			"DOM"=>"Dominican Republic",
			"ECU"=>"Ecuador",
			"EGY"=>"Egypt",
			"SLV"=>"El Salvador",
			"GNQ"=>"Equatorial Guinea",
			"ERI"=>"Eritrea",
			"EST"=>"Estonia",
			"ETH"=>"Ethiopia",
			"FLK"=>"Falkland Islands (Malvinas)",
			"FRO"=>"Faroe Islands",
			"FJI"=>"Fiji",
			"FIN"=>"Finland",
			"FRA"=>"France",
			"GUF"=>"French Guiana",
			"PYF"=>"French Polynesia",
			"ATF"=>"French Southern Territories",
			"GAB"=>"Gabon",
			"GMB"=>"Gambia",
			"GEO"=>"Georgia",
			"DEU"=>"Germany",
			"GHA"=>"Ghana",
			"GIB"=>"Gibraltar",
			"GRC"=>"Greece",
			"GRL"=>"Greenland",
			"GRD"=>"Grenada",
			"GLP"=>"Guadeloupe",
			"GUM"=>"Guam",
			"GTM"=>"Guatemala",
			"GGY"=>"Guernsey",
			"GIN"=>"Guinea",
			"GNB"=>"Guinea-Bissau",
			"GUY"=>"Guyana",
			"HTI"=>"Haiti",
			"HMD"=>"Heard Island and McDonald Islands",
			"VAT"=>"Holy See (Vatican City State)",
			"HND"=>"Honduras",
			"HKG"=>"Hong Kong",
			"HUN"=>"Hungary",
			"ISL"=>"Iceland",
			"IND"=>"India",
			"IDN"=>"Indonesia",
			"IRN"=>"Iran, Islamic Republic of",
			"IRQ"=>"Iraq",
			"IRL"=>"Ireland",
			"IMN"=>"Isle of Man",
			"ISR"=>"Israel",
			"ITA"=>"Italy",
			"JAM"=>"Jamaica",
			"JPN"=>"Japan",
			"JEY"=>"Jersey",
			"JOR"=>"Jordan",
			"KAZ"=>"Kazakhstan",
			"KEN"=>"Kenya",
			"KIR"=>"Kiribati",
			"PRK"=>"Korea, Democratic People's Republic of",
			"KOR"=>"Korea, Republic of",
			"KWT"=>"Kuwait",
			"KGZ"=>"Kyrgyzstan",
			"LAO"=>"Lao People's Democratic Republic",
			"LVA"=>"Latvia",
			"LBN"=>"Lebanon",
			"LSO"=>"Lesotho",
			"LBR"=>"Liberia",
			"LBY"=>"Libya",
			"LIE"=>"Liechtenstein",
			"LTU"=>"Lithuania",
			"LUX"=>"Luxembourg",
			"MAC"=>"Macao",
			"MKD"=>"Macedonia, the former Yugoslav Republic of",
			"MDG"=>"Madagascar",
			"MWI"=>"Malawi",
			"MYS"=>"Malaysia",
			"MDV"=>"Maldives",
			"MLI"=>"Mali",
			"MLT"=>"Malta",
			"MHL"=>"Marshall Islands",
			"MTQ"=>"Martinique",
			"MRT"=>"Mauritania",
			"MUS"=>"Mauritius",
			"MYT"=>"Mayotte",
			"MEX"=>"Mexico",
			"FSM"=>"Micronesia, Federated States of",
			"MDA"=>"Moldova, Republic of",
			"MCO"=>"Monaco",
			"MNG"=>"Mongolia",
			"MNE"=>"Montenegro",
			"MSR"=>"Montserrat",
			"MAR"=>"Morocco",
			"MOZ"=>"Mozambique",
			"MMR"=>"Myanmar",
			"NAM"=>"Namibia",
			"NRU"=>"Nauru",
			"NPL"=>"Nepal",
			"NLD"=>"Netherlands",
			"NCL"=>"New Caledonia",
			"NZL"=>"New Zealand",
			"NIC"=>"Nicaragua",
			"NER"=>"Niger",
			"NGA"=>"Nigeria",
			"NIU"=>"Niue",
			"NFK"=>"Norfolk Island",
			"MNP"=>"Northern Mariana Islands",
			"NOR"=>"Norway",
			"OMN"=>"Oman",
			"PAK"=>"Pakistan",
			"PLW"=>"Palau",
			"PSE"=>"Palestinian Territory, Occupied",
			"PAN"=>"Panama",
			"PNG"=>"Papua New Guinea",
			"PRY"=>"Paraguay",
			"PER"=>"Peru",
			"PHL"=>"Philippines",
			"PCN"=>"Pitcairn",
			"POL"=>"Poland",
			"PRT"=>"Portugal",
			"PRI"=>"Puerto Rico",
			"QAT"=>"Qatar",
			"REU"=>"Réunion",
			"ROU"=>"Romania",
			"RUS"=>"Russian Federation",
			"RWA"=>"Rwanda",
			"BLM"=>"Saint Barthélemy",
			"SHN"=>"Saint Helena, Ascension and Tristan da Cunha",
			"KNA"=>"Saint Kitts and Nevis",
			"LCA"=>"Saint Lucia",
			"MAF"=>"Saint Martin (French part)",
			"SPM"=>"Saint Pierre and Miquelon",
			"VCT"=>"Saint Vincent and the Grenadines",
			"WSM"=>"Samoa",
			"SMR"=>"San Marino",
			"STP"=>"Sao Tome and Principe",
			"SAU"=>"Saudi Arabia",
			"SEN"=>"Senegal",
			"SRB"=>"Serbia",
			"SYC"=>"Seychelles",
			"SLE"=>"Sierra Leone",
			"SGP"=>"Singapore",
			"SXM"=>"Sint Maarten (Dutch part)",
			"SVK"=>"Slovakia",
			"SVN"=>"Slovenia",
			"SLB"=>"Solomon Islands",
			"SOM"=>"Somalia",
			"ZAF"=>"South Africa",
			"SGS"=>"South Georgia and the South Sandwich Islands",
			"SSD"=>"South Sudan",
			"ESP"=>"Spain",
			"LKA"=>"Sri Lanka",
			"SDN"=>"Sudan",
			"SUR"=>"Suriname",
			"SJM"=>"Svalbard and Jan Mayen",
			"SWZ"=>"Swaziland",
			"SWE"=>"Sweden",
			"CHE"=>"Switzerland",
			"SYR"=>"Syrian Arab Republic",
			"TWN"=>"Taiwan, Province of China",
			"TJK"=>"Tajikistan",
			"TZA"=>"Tanzania, United Republic of",
			"THA"=>"Thailand",
			"TLS"=>"Timor-Leste",
			"TGO"=>"Togo",
			"TKL"=>"Tokelau",
			"TON"=>"Tonga",
			"TTO"=>"Trinidad and Tobago",
			"TUN"=>"Tunisia",
			"TUR"=>"Turkey",
			"TKM"=>"Turkmenistan",
			"TCA"=>"Turks and Caicos Islands",
			"TUV"=>"Tuvalu",
			"UGA"=>"Uganda",
			"UKR"=>"Ukraine",
			"ARE"=>"United Arab Emirates",
			"GBR"=>"United Kingdom",
			"USA"=>"United States",
			"UMI"=>"United States Minor Outlying Islands",
			"URY"=>"Uruguay",
			"UZB"=>"Uzbekistan",
			"VUT"=>"Vanuatu",
			"VEN"=>"Venezuela, Bolivarian Republic of",
			"VNM"=>"Viet Nam",
			"VGB"=>"Virgin Islands, British",
			"VIR"=>"Virgin Islands, U.S.",
			"WLF"=>"Wallis and Futuna",
			"ESH"=>"Western Sahara",
			"YEM"=>"Yemen",
			"ZMB"=>"Zambia",
			"ZWE"=>"Zimbabwe"
		);
        $options = apply_filters( 'wp_travel_engine_country_options', $options );
        return $options;
	}

	function order_form_billing_options()
	{

		$options = array(
					'fname' => array(
							'label'=>'First Name',
							'type'=>'text',
							'placeholder'=>'Your First Name',
							'required'=>'1'
						),
					'lname' => array(
							'label'=>'Last Name',
							'type'=>'text',
							'placeholder'=>'Your Last Name',
							'required'=>'1'
						),
					'email' => array(
							'label'=>'Email',
							'type'=>'email',
							'placeholder'=>'Your Valid Email',
							'required'=>'1'
						),
					'address' => array(
							'label'=>'Address',
							'type'=>'text',
							'placeholder'=>'Your Address',
							'required'=>'1'
						),
					'city' => array(
							'label'=>'City',
							'type'=>'text',
							'placeholder'=>'Your City',
							'required'=>'1'
						),
					'country' => array(
							'label'=>'Country',
							'type'=>'country-list',
							'required'=>'1'
						),
		);
		$options = apply_filters( 'wp_travel_engine_order_form_billing_options', $options );
        return $options;
	}

	function order_form_personal_options()
	{

		$options = array(
					'title'	=> array(
							'label'			=>'Title',
							'type'			=>'select',
							'required'		=> '1',
							'options'		=>array(
												'Mr'	=>'Mr',
												'Mrs'	=>'Mrs',
												'Ms'	=>'Ms',
												'Miss'	=>'Miss',
												'Other'	=>'Other'
											)
						),
					'fname' 	=> array(
							'label'			=>'First Name',
							'type'			=>'text',
							'placeholder'	=>'Your First Name',
							'required'		=>'1'
						),
					'lname' 	=> array(
							'label'			=>'Last Name',
							'type'			=>'text',
							'placeholder'	=>'Your Last Name',
							'required'		=>'1'
						),
					'passport' 	=> array(
							'label'			=>'Passport Number',
							'type'			=>'text',
							'placeholder'	=>'Your Valid Passport Number',
							'required'		=>'1'
						),
					'email' 	=> array(
							'label'			=>'Email',
							'type'			=>'email',
							'placeholder'	=>'Your Valid Email',
							'required'		=>'1'
						),
					'address' 	=> array(
							'label'			=>'Address',
							'type'			=>'text',
							'placeholder'	=>'Your Address',
							'required'		=>'1'
						),
					'city' 		=> array(
							'label'			=>'City',
							'type'			=>'text',
							'placeholder'	=>'Your City',
							'required'		=>'1'
						),
					'country' 	=> array(
							'label'			=>'Country',
							'type'			=>'country-list',
							'required'		=>'1'
						),
					'postcode' 	=> array(
							'label'			=>'Post-code',
							'type'			=>'number',
							'required'		=>'1'
						),
					'phone'    	=> array(
							'label'			=>'Phone',
							'type'			=>'tel',
							'required'		=>'1'
						),
					'dob'		=> array(
							'label'			=>'Date of Birth',
							'type'			=>'text',
							'required'		=> '1'
						),
					'special'	=> array(
							'label'			=>'Special Requirements',
							'type'			=>'textarea',
							'required'		=> '1'
						),
				);
		$options = apply_filters( 'wp_travel_engine_order_form_personal_options', $options );
        return $options;
	}

	function wpte_enquiry_options()
	{

		$options = array(
					
					'name' 	=> array(
							'label'			=>__('Your Name','wp-travel-engine'),
							'type'			=>'text',
							'placeholder'	=>__('Enter Your Name','wp-travel-engine'),
							'required'		=>'1'
						),
					'country' 	=> array(
							'label'			=>__('Country','wp-travel-engine'),
							'type'			=>'country-list',
							'placeholder'	=>__('Choose a country&hellip;','wp-travel-engine'),
							'required'		=>'1'
						),
					'contact'    	=> array(
							'label'			=>__('Contact No.','wp-travel-engine'),
							'type'			=>'tel',
							'placeholder'	=>__('Enter Your Contact Number','wp-travel-engine'),
							'required'		=>'1'
						),
					'adults'		=> array(
							'label'			=>__('Adults','wp-travel-engine'),
							'type'			=>'number',
							'placeholder'	=>__('Enter Number of Adults','wp-travel-engine'),
							'required'		=> '1'
						),
					'children'		=> array(
							'label'			=>__('Children','wp-travel-engine'),
							'type'			=>'number',
							'placeholder'	=>__('Enter Number of Children','wp-travel-engine'),
							'required'		=> '1'
						),
					'message'	=> array(
							'label'			=>__('Your Message','wp-travel-engine'),
							'type'			=>'textarea',
							'placeholder'	=>__('Enter Your message','wp-travel-engine'),
							'required'		=> '1'
						),
				);
		$options = apply_filters( 'wp_travel_engine_inquiry_form_options', $options );
        return $options;
	}


	function order_form_relation_options()
	{

		$options = array(
					'title'	=> array(
							'label'			=>'Title',
							'type'			=>'select',
							'required'		=> '1',
							'options'		=>array(
												'Mr'	=>'Mr',
												'Mrs'	=>'Mrs',
												'Ms'	=>'Ms',
												'Miss'	=>'Miss',
												'Other'	=>'Other'
											)
						),
					'fname' => array(
							'label'=>'First Name',
							'type'=>'text',
							'placeholder'=>'Your First Name',
							'required'=>'1'
						),
					'lname' => array(
							'label'=>'Last Name',
							'type'=>'text',
							'placeholder'=>'Your Last Name',
							'required'=>'1'
						),
					'phone' => array(
							'label'=>'Phone',
							'type'=>'tel',
							'required'=>'1'
						),
					'relation' => array(
							'label'=>'Relationship',
							'type'=>'text',
							'required'=>'1'
						),
		);
		$options = apply_filters( 'wp_travel_engine_order_form_relation_options', $options );
        return $options;
	}

	/**
	* Get gender options.
	*
	* @param string $options (default: '')
	* @return string
	*/
 	function gender_options()
	{
		$options = array(
            'male'		=> 'male',
            'female' 	=> 'female',
            'other' 	=> 'other',
            );
        $options = apply_filters( 'wp_travel_engine_gender_options', $options );
        return $options;
	}

	function wp_mail_from() {
		$current_site = get_option('blogname');
    	return 'wordpress@'.$current_site;
	}

	/**
	 * Sanitize a multidimensional array
	 *
	 * @uses htmlspecialchars
	 *
	 * @param (array)
	 * @return (array) the sanitized array
	 */
	function wte_sanitize_array ($data = array()) {
		if (!is_array($data) || !count($data)) {
			return array();
		}
		foreach ($data as $k => $v) {
			if (!is_array($v) && !is_object($v)) {
				$data[$k] = htmlspecialchars(trim($v));
			}
			if (is_array($v)) {
				$data[$k] = $this->wte_sanitize_array($v);
			}
		}
		return $data;
	}
}
$obj = new Wp_Travel_Engine_Functions;
$obj->init();