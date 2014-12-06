<?php
/*
package: Centraleffects Framework
Author: Rex Bengil
Website: Centraleffects.com
Company: Centraleffects BPO
----------------------------------
General Class will handle all request of the site. 
Find the appropriate pages and display to the user
*/
if(empty($_SESSION)){ session_start(); }

class SKgeneral extends SKdatabase
{
	public $alldata;
	public $subpageData;
	public $requestedpage;
	public $subpage;
	public $enable_subpage;
	public $active_class;
	public $request_uri;
	
	/*
	We are going to set the values here and pass to our public pages 
	since we do not want to create db queries on public pages
	*/
	public function SKgeneral()
	{
		/**/
	}
	
	#This use to set variables that we later pass to public pages
	public function set($param,$val)
	{
		if(empty($this->subpage)){
			$this->alldata[$param] = $val;
		}else
		{
			$this->subpageData[$param] = $val;
		}

		//$this->alldata['request_uri'] = $_REQUEST["serv_uri"];
		$this->alldata['page'] = $_REQUEST["page"];
		$this->alldata['subpage'] = $_REQUEST["subpage"];
		
		$this->subpageData['request_uri'] = $_REQUEST["uri"];
		$this->subpageData['page'] = $_REQUEST["page"];
		$this->subpageData['subpage'] = $_REQUEST["subpage"];
	}
	
	/*
	Set what pages we are going to render here
	*/
	public function render($requestedPage)
	{
		$this->requestedpage=$requestedPage;
	}
	
	#return what subpage that exists
	public function get_subpage()
	{
		return $this->subpage;
	}
	public function current_page()
	{
		return $this->requestedpage;
	}
	public function display()
	{
		$this->set('session',$_SESSION);
		$this->set('request',$_REQUEST);
		$data = $this->alldata;
		if($this->requestedpage==""){ include_once(PUBLIC_FOLDER.'page_not_found.php');  }
		
			if(file_exists(PUBLIC_FOLDER.$this->requestedpage.'.php')){
				include_once(PUBLIC_FOLDER.$this->requestedpage.'.php');
			}else
			{
				include_once(PUBLIC_FOLDER.'page_not_found.php');
			}
		
		
	}
	public function headers()
	{
		$data = $this->alldata;
		include_once(PUBLIC_FOLDER.'header.php');
	}
	public function footers()
	{
		$data = $this->alldata;
		include_once(PUBLIC_FOLDER.'footer.php');
	}
	
	#This is to display 404 page
	public function display404()
	{
		$this->set('title',$this->get_subpage());
		$data = $this->alldata;
		include_once(PUBLIC_FOLDER.'page_not_found.php');
	}
	
	#Use to redirect a page
	public function redirect($url)
	{
		if (!headers_sent()) {
			header('Location:'.BASE_URL.$url);
			exit;
		}else
		{
			?>
            <script type="text/javascript">document.location.href='<?php echo BASE_URL.$url; ?>';</script>
            <?php
		}
	}
	
	#Return requested query strings like ?myvariable=value&mysecondvar=value2...
	public function get_uri()
	{
		return $this->request_uri;
	}
	
	#return current user
	public function checkLogin()
	{
		if(empty($_SESSION["session"]["currentLogin"]))
		{
			return false;
		}else
		{
			return $_SESSION["session"]["currentLogin"];
		}
	}
	
	#check page permission
	public function check_page_permission()
	{
		global $CFG;
		
	}
	
	public function data()
	{
		return $this->alldata;
	}
	public function pr($data)
	{
		echo'<pre>';
		print_r($data);
		echo'</pre>';
	}
	public function alert($message)
	{
		if(empty($_SESSION)){ session_start(); }
		$_SESSION["session"]["alert"] = $message;
		echo'<script type="text/javascript"> alert(\''.$message.'\');</script>';
	}
	
	#This is to generate a hash password 
	public function hash_password($string)
	{
		return md5(SYS_SALT).md5($this->clean($string));
	}
	
	#return user id of the current user and return false if nothing
	public function current_userid()
	{
		
		if(empty($_SESSION)){ session_start(); }
		if($_SESSION["currentLogin"]["id"]=="")
		{
			return false;
		}else{
			return (int)$_SESSION["currentLogin"]["id"];
		}
	
	}
	
	#Create a reference code
	#return a string
	#$ordertype = [wo, cr]
	public function reference_code($idno,$ordertype)
	{
		$idno = (int)$idno + 1000000;
	 return strtoupper(substr($ordertype,0,2).decoct($idno));
	}
	
	#Get ID from reference code
	#return an array
	public function getID_reference_code($referencecode)
	{
		$ordertype = substr($referencecode,0,2);
		$ids = substr($referencecode,2,strlen($referencecode)-2);
		$converted = octdec($ids);
		$id = $converted - 1000000;
		return array("id"=>$id,"ids"=>$ids,"order_type"=>$ordertype,'converted'=>$converted);
	}
	function timeago($date)
	{
			date_default_timezone_set("Asia/Manila"); 
			//$cur_time= strtotime(date('Y-m-d h:i:s'));//time();
			$cur_time= strtotime(date('Y-m-d h:i:s e'));
			//echo date('h:i:s',$cur_time);

			//$time_elapsed = $cur_time - strtotime(date('Y-m-d h:i:s',strtotime($date)));
			$time_elapsed = $cur_time - (int)$date;

			$seconds = $time_elapsed ;
			$minutes = round($time_elapsed / 60 );
			$hours = round($time_elapsed / 3600);
			$days = round($time_elapsed / 86400 );
			$weeks = round($time_elapsed / 604800);
			$months = round($time_elapsed / 2600640 );
			$years = round($time_elapsed / 31207680 );
			if($seconds == 0){
			$ago= "just now";
			}
			// Seconds
			else if($seconds <= 60)
			{
			$ago= "$seconds seconds ago";
			}
			//Minutes
			else if($minutes <=60)
			{
			if($minutes==1)
			{
			$ago= "one minute ago";
			}
			else
			{
			$ago= "$minutes minutes ago";
			}
			}
			//Hours
			else if($hours <=24)
			{
			if($hours==1)
			{
			$ago= "an hour ago";
			}
			else
			{
			$ago= "$hours hours ago";
			}
			}
			//Days
			else if($days <= 7)
			{
			if($days==1)
			{
			$ago= "yesterday";
			}
			else
			{
			$ago= "$days days ago";
			}
			}
			//Weeks
			else if($weeks <= 4.3)
			{
			if($weeks==1)
			{
			$ago= "a week ago";
			}
			else
			{
			$ago= "$weeks weeks ago";
			}
			}
			//Months
			else if($months <=12)
			{
			if($months==1)
			{
			$ago= "a month ago";
			}
			else
			{
			$ago= "$months months ago";
			}
			}
			//Years
			else
			{
			if($years==1)
			{
			$ago= "one year ago";
			}
			else
			{
			$ago= "$years years ago";
			}
			}
			
			return $ago;
				 
	}

	/*get user meta */
	public function get_user_meta($userid,$key,$single=false){
		if($single==false){
			return $this->fetch("select meta_value from user_meta_tb where user_id='".$userid."' and meta_key='".$key."'");
		}else{
			return $this->get_var("select meta_value from user_meta_tb where user_id='".$userid."' and meta_key='".$key."' LIMIT 1");
		}
	}

	public function insert_user_meta($userid,$key,$value){
		 $y = $this->get_var("select count(*) from user_meta_tb where user_id='".$userid."' and meta_key='".$key."' and meta_value='".$value."'");
		if($y>0){ return false; }
		
		return $this->insert("user_meta_tb",
				array(
					"user_id"=>$userid,
					"meta_key"=>$key,
					"meta_value"=>$value
					)
			);
	}
	public function country($abbr=""){
		$countries = array(
						"AF" => "Afghanistan",
						"AX" => "Åland Islands",
						"AL" => "Albania",
						"DZ" => "Algeria",
						"AS" => "American Samoa",
						"AD" => "Andorra",
						"AO" => "Angola",
						"AI" => "Anguilla",
						"AQ" => "Antarctica",
						"AG" => "Antigua and Barbuda",
						"AR" => "Argentina",
						"AM" => "Armenia",
						"AW" => "Aruba",
						"AU" => "Australia",
						"AT" => "Austria",
						"AZ" => "Azerbaijan",
						"BS" => "Bahamas",
						"BH" => "Bahrain",
						"BD" => "Bangladesh",
						"BB" => "Barbados",
						"BY" => "Belarus",
						"BE" => "Belgium",
						"BZ" => "Belize",
						"BJ" => "Benin",
						"BM" => "Bermuda",
						"BT" => "Bhutan",
						"BO" => "Bolivia",
						"BA" => "Bosnia and Herzegovina",
						"BW" => "Botswana",
						"BV" => "Bouvet Island",
						"BR" => "Brazil",
						"IO" => "British Indian Ocean Territory",
						"BN" => "Brunei Darussalam",
						"BG" => "Bulgaria",
						"BF" => "Burkina Faso",
						"BI" => "Burundi",
						"KH" => "Cambodia",
						"CM" => "Cameroon",
						"CA" => "Canada",
						"CV" => "Cape Verde",
						"KY" => "Cayman Islands",
						"CF" => "Central African Republic",
						"TD" => "Chad",
						"CL" => "Chile",
						"CN" => "China",
						"CX" => "Christmas Island",
						"CC" => "Cocos (Keeling) Islands",
						"CO" => "Colombia",
						"KM" => "Comoros",
						"CG" => "Congo",
						"CD" => "Congo, The Democratic Republic of The",
						"CK" => "Cook Islands",
						"CR" => "Costa Rica",
						"CI" => "Cote D'ivoire",
						"HR" => "Croatia",
						"CU" => "Cuba",
						"CY" => "Cyprus",
						"CZ" => "Czech Republic",
						"DK" => "Denmark",
						"DJ" => "Djibouti",
						"DM" => "Dominica",
						"DO" => "Dominican Republic",
						"EC" => "Ecuador",
						"EG" => "Egypt",
						"SV" => "El Salvador",
						"GQ" => "Equatorial Guinea",
						"ER" => "Eritrea",
						"EE" => "Estonia",
						"ET" => "Ethiopia",
						"FK" => "Falkland Islands (Malvinas)",
						"FO" => "Faroe Islands",
						"FJ" => "Fiji",
						"FI" => "Finland",
						"FR" => "France",
						"GF" => "French Guiana",
						"PF" => "French Polynesia",
						"TF" => "French Southern Territories",
						"GA" => "Gabon",
						"GM" => "Gambia",
						"GE" => "Georgia",
						"DE" => "Germany",
						"GH" => "Ghana",
						"GI" => "Gibraltar",
						"GR" => "Greece",
						"GL" => "Greenland",
						"GD" => "Grenada",
						"GP" => "Guadeloupe",
						"GU" => "Guam",
						"GT" => "Guatemala",
						"GG" => "Guernsey",
						"GN" => "Guinea",
						"GW" => "Guinea-bissau",
						"GY" => "Guyana",
						"HT" => "Haiti",
						"HM" => "Heard Island and Mcdonald Islands",
						"VA" => "Holy See (Vatican City State)",
						"HN" => "Honduras",
						"HK" => "Hong Kong",
						"HU" => "Hungary",
						"IS" => "Iceland",
						"IN" => "India",
						"ID" => "Indonesia",
						"IR" => "Iran, Islamic Republic of",
						"IQ" => "Iraq",
						"IE" => "Ireland",
						"IM" => "Isle of Man",
						"IL" => "Israel",
						"IT" => "Italy",
						"JM" => "Jamaica",
						"JP" => "Japan",
						"JE" => "Jersey",
						"JO" => "Jordan",
						"KZ" => "Kazakhstan",
						"KE" => "Kenya",
						"KI" => "Kiribati",
						"KP" => "Korea, Democratic People's Republic of",
						"KR" => "Korea, Republic of",
						"KW" => "Kuwait",
						"KG" => "Kyrgyzstan",
						"LA" => "Lao People's Democratic Republic",
						"LV" => "Latvia",
						"LB" => "Lebanon",
						"LS" => "Lesotho",
						"LR" => "Liberia",
						"LY" => "Libyan Arab Jamahiriya",
						"LI" => "Liechtenstein",
						"LT" => "Lithuania",
						"LU" => "Luxembourg",
						"MO" => "Macao",
						"MK" => "Macedonia, The Former Yugoslav Republic of",
						"MG" => "Madagascar",
						"MW" => "Malawi",
						"MY" => "Malaysia",
						"MV" => "Maldives",
						"ML" => "Mali",
						"MT" => "Malta",
						"MH" => "Marshall Islands",
						"MQ" => "Martinique",
						"MR" => "Mauritania",
						"MU" => "Mauritius",
						"YT" => "Mayotte",
						"MX" => "Mexico",
						"FM" => "Micronesia, Federated States of",
						"MD" => "Moldova, Republic of",
						"MC" => "Monaco",
						"MN" => "Mongolia",
						"ME" => "Montenegro",
						"MS" => "Montserrat",
						"MA" => "Morocco",
						"MZ" => "Mozambique",
						"MM" => "Myanmar",
						"NA" => "Namibia",
						"NR" => "Nauru",
						"NP" => "Nepal",
						"NL" => "Netherlands",
						"AN" => "Netherlands Antilles",
						"NC" => "New Caledonia",
						"NZ" => "New Zealand",
						"NI" => "Nicaragua",
						"NE" => "Niger",
						"NG" => "Nigeria",
						"NU" => "Niue",
						"NF" => "Norfolk Island",
						"MP" => "Northern Mariana Islands",
						"NO" => "Norway",
						"OM" => "Oman",
						"PK" => "Pakistan",
						"PW" => "Palau",
						"PS" => "Palestinian Territory, Occupied",
						"PA" => "Panama",
						"PG" => "Papua New Guinea",
						"PY" => "Paraguay",
						"PE" => "Peru",
						"PH" => "Philippines",
						"PN" => "Pitcairn",
						"PL" => "Poland",
						"PT" => "Portugal",
						"PR" => "Puerto Rico",
						"QA" => "Qatar",
						"RE" => "Reunion",
						"RO" => "Romania",
						"RU" => "Russian Federation",
						"RW" => "Rwanda",
						"SH" => "Saint Helena",
						"KN" => "Saint Kitts and Nevis",
						"LC" => "Saint Lucia",
						"PM" => "Saint Pierre and Miquelon",
						"VC" => "Saint Vincent and The Grenadines",
						"WS" => "Samoa",
						"SM" => "San Marino",
						"ST" => "Sao Tome and Principe",
						"SA" => "Saudi Arabia",
						"SN" => "Senegal",
						"RS" => "Serbia",
						"SC" => "Seychelles",
						"SL" => "Sierra Leone",
						"SG" => "Singapore",
						"SK" => "Slovakia",
						"SI" => "Slovenia",
						"SB" => "Solomon Islands",
						"SO" => "Somalia",
						"ZA" => "South Africa",
						"GS" => "South Georgia and The South Sandwich Islands",
						"ES" => "Spain",
						"LK" => "Sri Lanka",
						"SD" => "Sudan",
						"SR" => "Suriname",
						"SJ" => "Svalbard and Jan Mayen",
						"SZ" => "Swaziland",
						"SE" => "Sweden",
						"CH" => "Switzerland",
						"SY" => "Syrian Arab Republic",
						"TW" => "Taiwan, Province of China",
						"TJ" => "Tajikistan",
						"TZ" => "Tanzania, United Republic of",
						"TH" => "Thailand",
						"TL" => "Timor-leste",
						"TG" => "Togo",
						"TK" => "Tokelau",
						"TO" => "Tonga",
						"TT" => "Trinidad and Tobago",
						"TN" => "Tunisia",
						"TR" => "Turkey",
						"TM" => "Turkmenistan",
						"TC" => "Turks and Caicos Islands",
						"TV" => "Tuvalu",
						"UG" => "Uganda",
						"UA" => "Ukraine",
						"AE" => "United Arab Emirates",
						"GB" => "United Kingdom",
						"US" => "United States",
						"UM" => "United States Minor Outlying Islands",
						"UY" => "Uruguay",
						"UZ" => "Uzbekistan",
						"VU" => "Vanuatu",
						"VE" => "Venezuela",
						"VN" => "Viet Nam",
						"VG" => "Virgin Islands, British",
						"VI" => "Virgin Islands, U.S.",
						"WF" => "Wallis and Futuna",
						"EH" => "Western Sahara",
						"YE" => "Yemen",
						"ZM" => "Zambia",
						"ZW" => "Zimbabwe");

		if($abbr==""){
			return $countries;
		}else{
			return $countries[strtoupper($abbr)];
		}
	}

	//throw user to login page when sesssion dies.
	public function isloggedin(){
		if(empty($_SESSION)){
			$this->redirect('login');
		}
	}
}#end of class












?>