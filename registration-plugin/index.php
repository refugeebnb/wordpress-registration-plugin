<?php
/**
 * Entry Script of Refugee BNB Wordpress Plugin
 * 
 * Sets up Wordpress APIs, Admin Management Page, Post Meta Box, Meta Save functions along with a couple of utility
 * functions. 
 * 
 * @category 	Refugee BNB
 * @package 	Refugee BNB Labs
 * @subpackage	Utilities
 * @copyright	Copyright (c) 2015 RefugeeBNB Technologies INC. (https://github.com/RefugeeBNB)
 * @license		http://creativecommons.org/licenses/by-nc-nd/4.0/
 * @version 	0.0.1
 * @link		https://github.com/refugeebnb/wordpress-registration-plugin
 * @since		0.0.1
 * 
 */

/**
Plugin Name: Refugee BNB Wordpress Plugin
Plugin URI: https://github.com/Sszark/wordpress-registration-plugin
Description: A Rating Plugin for Wordpress Posts
Author: Refugee BNB
Version: 0.1
Author URI: https://github.com/refugeebnb/
*/

/**
 * Entry Class of Refugee BNB Wordpress Plugin
 * 
 * Sets up Wordpress APIs, Admin Management Page, Post Meta Box, Meta Save functions along with a couple of utility
 * functions. 
 * 
 * @category 	Refugee BNB
 * @package 	Refugee BNB Labs
 * @subpackage	Utilities
 * @copyright	Copyright (c) 2015 RefugeeBNB Technologies INC. (https://github.com/RefugeeBNB)
 * @license		http://creativecommons.org/licenses/by-nc-nd/4.0/
 * @version 	0.0.1
 * @link		https://github.com/refugeebnb/wordpress-registration-plugin
 * @since		0.0.1
 * 
 */
class RefugeeBnb{
	
	const NAME = "RefugeeBnb";
	private $option = false;
	public $uri = false;
	public $dir = false;
	public $pluginHome = "https://github.com/RefugeeBNB/wordpress-registration-plugin";
	public $setupFields = [ 
		'email' => ['Email','text'],
		'fb' => ['Facebook','text'], 
		'tw' => ['Twitter','text'], 
		'gram' => ['Instagram','text'], 
		'in' => ['LinkedIn','text'], 
		'pin' => ['Pinterest','text'], 
		'plus' => ['Google+','text'], 
		'address' => ['Address','textarea'], 
		'yt' => ['YouTube','text'], 
		'phone' => ['Phone','text'], 
		'mc_domain' => ['MailChimp Domain','text','Something Like "us11"'], 
		'mc_api' => ['MailChimp API Key','text'], 
		'mc_list' => ['MailChimp List ID','text'],
	];
	
	const OTHER_ROLE = 'other_provider';
	const SHELTER_ROLE = 'shelter_provider';
	/**
	 * Fragmants to be Translated
	 */
	
	/**
	 * Sets Up Wordpress Hooks and Actions used by the Plugin
	 * 
	 * @return	null
	 */
	function RefugeeBnb()
	{
		//register_activation_hook(__FILE__, array(&$this,'setup')); // Run Setup Functions
		add_action("admin_init",array(&$this,"init")); //Run Init Functions
		add_action("init",array(&$this,"init")); //Run Init Functions
		add_action("admin_menu",array(&$this,"menu"));
		add_action("wp_ajax_".self::NAME,array(&$this,"ajax"));
		add_action("wp_ajax_nopriv_".self::NAME,array(&$this,"ajax"));
		add_action('admin_enqueue_scripts',array(&$this,'dependencies'),1000);
		add_action('wp_enqueue_scripts',array(&$this,'dependencies'),1000);
		add_role( self::SHELTER_ROLE, 'Shelter Provider', ['read'=>true] );
		add_role( self::OTHER_ROLE, 'Other Provider', ['read'=>true] );
		add_filter( 'show_admin_bar', '__return_false' );
	}
	
	/**
	 * Initialization Call, setups of the Basic Class variables: 'option', 'dir' and 'uri'
	 * 
	 * @return	null
	 */
	public function init()
	{
		$option = (array)json_decode(get_option(self::NAME."_option"),true);
		if(!empty($option))
			$this->option = $option;
		/**
		 * Set it up
		 */
		$cookie = $_COOKIE['lang-selected'];
		$lang = false;
		if(empty($cookie))
		{
			$ip = ip2long(self::get_client_ip()[1]);
			foreach($this->option['Langs'] as $slug=>$_lang)
			{
				foreach($_lang['lookup'] as $range)
				{
					if(ip2long($range[0]) <= $ip && ip2long($range[1]) >= $ip)
					{
						$lang = $slug;
						break;
					}
				}
				if($lang)
					break;
			}
			if($lang)
				setcookie('lang-selected',$lang,time()+60*60*24*365*10,"/");
		}
		$this->dir = wp_upload_dir()['basedir']."/".self::NAME;
		$this->uri = plugin_dir_url(__FILE__)."";
	}
	
	public static function get_client_ip() {
    	$ip_addresses = array();
	$ip_elements = array(
		'HTTP_X_FORWARDED_FOR', 'HTTP_FORWARDED_FOR',
		'HTTP_X_FORWARDED', 'HTTP_FORWARDED',
		'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_CLUSTER_CLIENT_IP',
		'HTTP_X_CLIENT_IP', 'HTTP_CLIENT_IP',
		'REMOTE_ADDR'
	);
	foreach ( $ip_elements as $element ) {
		if(isset($_SERVER[$element])) {
			if ( !is_string($_SERVER[$element]) ) {
				// Log the value somehow, to improve the script!
				continue;
			}
			$address_list = explode(',', $_SERVER[$element]);
			$address_list = array_map('trim', $address_list);
			// Not using array_merge in order to preserve order
			foreach ( $address_list as $x ) {
				$ip_addresses[] = $x;
			}
		}
	}
	if ( count($ip_addresses)==0 ) {
		return FALSE;
	} elseif ( $force_string===TRUE || ( $force_string===NULL && count($ip_addresses)==1 ) ) {
		return $ip_addresses[0];
	} else {
		return $ip_addresses;
	}

	}
	
	/**
	 * Plugin Activation Call - which create the necessary tables
	 * 
	 * @return	null
	 */
	public function setup(){}
	
	/**
	 * Loads CSS and Javascript Dependencies for the Admin Management Page and for the Meta box of the
	 * Post Editing Page
	 * 
	 * @param	string	$hook	The Page hook of the Wordpress Admin Page
	 * @return	null
	 */
	public function dependencies($hook)
	{
		/**
		 * Core
		 */
		wp_register_style('bootstrap-core',$this->uri.'css/bootstrap.min.css');
		wp_register_style('bootstrap-theme',$this->uri.'css/bootstrap-theme.min.css',['bootstrap-core']);
		wp_register_style('sz-icomoon',$this->uri."css/icomoon.css");
		wp_register_script('bootstrap-js',$this->uri.'js/bootstrap.min.js',['jquery','json2']);
		wp_register_script('jq-COOKIE',$this->uri.'js/cookie.js',['jquery','json2']);
		wp_register_script('sz-plugin-form-model',$this->uri."js/form.js",['jquery','json2']);
		
		/**
		 * Setup Page
		 */
		wp_register_style('refbnb-plugin-setup-page', $this->uri.'css/page.css',['bootstrap-core','bootstrap-theme','sz-icomoon']);
		if($hook == "toplevel_page_".self::NAME)
			wp_enqueue_style('refbnb-plugin-setup-page');
		/**
		 * Language Page
		 */
		wp_register_script('refbnb-plugin-lang-page', $this->uri.'js/page-lang.js',['jquery-form','sz-plugin-form-model','bootstrap-js']);
		if($hook == "refugee-plugin_page_RefugeeBnb-lang")
		{
			wp_enqueue_style('refbnb-plugin-setup-page');
			wp_enqueue_script('refbnb-plugin-lang-page');
		}
		/**
		 * Frontend
		 */
		wp_register_script('frontend-crud',$this->uri."js/frontend.js",['jquery','json2','jquery-form','sz-plugin-form-model','jq-COOKIE']);
		if(!is_admin())
		{
			wp_enqueue_script('frontend-crud');
			wp_localize_script( 'jquery', self::NAME,  array( 
				'ajaxurl' => admin_url('admin-ajax.php'),
			));
		}	
	}
	
	/**
	 * Registers the Plugin's Admin Page
	 * 
	 * @return	null
	 */
	public function menu()
	{
		add_menu_page("Refugee Plugin", "Refugee Plugin", "activate_plugins", self::NAME,array(&$this,"setupPage"),'dashicons-groups',999999);
		add_submenu_page(self::NAME, "Language Setup", "Language Setup", "activate_plugins", self::NAME."-lang",array(&$this,"langPage"),'dashicons-admin-comments');
		add_submenu_page(self::NAME, "Shelter Providers", "Shelter Providers", "activate_plugins", self::NAME."-shelter",array(&$this,"shelterPage"),'dashicons-store');
		add_submenu_page(self::NAME, "Other Providers", "Other Providers", "activate_plugins", self::NAME."-others",array(&$this,"othersPage"),'dashicons-heart');
	}
	
	/**
	 * Renders the Plugin's Setup Page which is used to Manage the various Plugin Criteria and to
	 * what post type they apply to.
	 * 
	 * @return	null
	 */
	public function setupPage()
	{
		if(isset($_POST[self::NAME]))
		{
			$this->option['Setup'] = $_POST[self::NAME];
            update_option(self::NAME."_option", json_encode($this->option));
		}
		$options = isset($this->option['Setup'])?$this->option['Setup']:[];
		include_once "page/page-setup.php";
	}
	
	
	/**
	 * Renders the Plugin's Setup Page which is used to Manage the various Plugin Criteria and to
	 * what post type they apply to.
	 * 
	 * @return	null
	 */
	public function langPage()
	{
		$options = $this->option; 
		include_once "page/page-lang.php";
	}
	
	/**
	 * Renders the Plugin's Setup Page which is used to Manage the various Plugin Criteria and to
	 * what post type they apply to.
	 * 
	 * @return	null
	 */
	public function shelterPage()
	{
		$options = $this->option; 
		include_once "page/page-shelter.php";
	}
	
	
	/**
	 * Renders the Plugin's Setup Page which is used to Manage the various Plugin Criteria and to
	 * what post type they apply to.
	 * 
	 * @return	null
	 */
	public function othersPage()
	{
		$options = $this->option; 
		include_once "page/page-others.php";
	}
	
	
	/**
	 * Handles Ajax Calls for the Plugin
	 * 
	 * @return 	null
	 */
	public function ajax()
	{
		$json = array('success' => false,'data' => null,'errors'=>false,'content'=>'');
		ob_start();
		switch($_REQUEST["type"])
		{
			case "cu-lang":
				$json = $this->cuLang($json); $json['data'] = $this->option['Langs'];   break;
			case "del-lang":
				$json = $this->delLang($json); $json['data'] = $this->option['Langs'];  break;
			case "translate-lang":
				$json = $this->translateLang($json); $json['data'] = $this->option['Langs'];  break;
			case 'express-interest':
				$json = $this->expressInterest($json); $json['data'] = [];  break;
			case 'shelter-signup':
				$json = $this->shelterSignup($json); $json['data'] = [];  break;
			case 'shelter-detail':
				$json = $this->shelterDetail($json); $json['data'] = [];  break;
		}
		$json['input'] = $_REQUEST;
		ob_end_clean();
		echo json_encode($json);exit;
	}
	
	public $translationFragments = [
		'Sign Up to host a refugee for 1 year, start Jan 1, 2016.',
		'I have no spare beds but I would like to help in other ways.',
		'Connect with us',
		'Email', 
		'I can offer',
		'Submit', 
		'Invalid Email',
		'You have already signed up. We will be in touch shortly.',
		'Kindly tell us how will you like to help',
		'Thanks for Signing Up! We will be in touch shortly!',
		//10
		'Password',
		'Express Interest',
		'Password is too short!',
		'How many rooms do you have?',
		'Bed Type',
		'How many beds',
		'Suited for',
		'About you',
		'Name',
		'Address',
		//20
		'2016 Residents',
		'Adults',
		'Children',
		'Languages in household',
		'Tell us about your household',
		'Invalid Data for Rooms',
		'Address cannot be empty',
		'Invalid Name',
		'Invalid User',
		'Both',
		 //30
		 'Invalid Room'
	];
	
	private function expressInterest($json)
	{
		$fields = $_REQUEST[self::NAME]['Others'];
		$errors = ['email'=>[],'offer'=>[]];
		/**
		 * Validate Fields
		 */
		//Email Validation
		$email = $fields['email'];
		if(!is_email($email))
			$errors['email'][] = '<span data-fragment="6">Invalid Email</span>';
		elseif(get_user_by_email($email))
			$errors['email'][] = '<span data-fragment="7">You have already signed up. We will be in touch shortly.</span>';
		//Offer Validate
		$offer = (string)trim($fields['offer']);
		if(empty($offer))
			$errors['offer'][] = '<span data-fragment="8">Kindly tell us how will you like to help</span>';
		$json['errors'] = $errors;
		$json['success'] = empty($errors['email']) && empty($errors['offer']);
		if($json['success'])
		{
			$user_id = wp_insert_user([
				'user_login'=>'user.'.time(),
				'user_pass' => wp_generate_password(12,true),
				'user_email' => $email,
				'role' => self::OTHER_ROLE
			]);
			update_user_meta($user_id, 'service', $offer);
			$json['message'] = '<span data-fragment="9">Thanks for Signing Up! We will be in touch shortly!</span>';
		}
		return $json;
	}
	
	private function shelterDetail($json)
	{
		$errors = ['rooms'=>[],'name'=>[],'address'=>[]];
		$current_user = wp_get_current_user();
		if ( !($current_user instanceof WP_User) )
		{
			$errors['rooms'][] = '<span data-fragment="28">Invalid User</span>';
			$json['errors'] = $errors;
			return $json;
		}
		$fields = $_REQUEST[self::NAME]['Shelter'];
		$user_id = $current_user->ID;
		$shelter = get_user_meta($user_id,'shelter',true);
		if(!empty($shelter))
		{
			$json['message'] = '<span data-fragment="7">You have already signed up. We will be in touch shortly.</span>';
			return $json;
		}
		//Validate Fields
		$name = $fields['name'];
		if(empty($name))
			$errors['name'][] = '<span data-fragment="27">Invalid Name</span>';
		$address = $fields['address'];
		if(empty($address))
			$errors['address'][] = '<span data-fragment="26">Address cannot be empty</span>';
		$rooms = trim($fields['rooms']);
		if(!is_numeric($rooms) || $rooms <0 || $rooms > 5)
			$errors['rooms'][] = '<span data-fragment="30">Invalid Room</span>';
		else{
			$roomData = [];
			for($x=0;$x<$rooms;$x++)
			{
				$single = $fields['single'][$x];
				$double = $fields['double'][$x];
				$doubleType = $fields['double-type'][$x];
				$singleType = $fields['single-type'][$x];
				if(!is_numeric($single) || !is_numeric($double) || empty($doubleType) || empty($singleType))
				{
					$errors['rooms'][] = '<span data-fragment="30">Invalid Room</span>: '.($x+1);
				}
			}
		} 
		
		$json['errors'] = $errors;
		$json['success'] = empty($errors['rooms']) && empty($errors['name']) && empty($errors['address']);
		
		if($json['success'])
		{
			update_user_meta($user_id, 'shelter', json_encode($fields));
			$json['message'] = '<span data-fragment="9">Thanks for Signing Up! We will be in touch shortly!</span>';
		}
		
		return $json;
	}
	
	private function shelterSignup($json)
	{
		$fields = $_REQUEST[self::NAME]['Shelter'];
		$errors = ['email'=>[],'password'=>[]];
		/**
		 * Validate Fields
		 */
		//Email Validation
		$email = $fields['email'];
		if(!is_email($email))
			$errors['email'][] = '<span data-fragment="6">Invalid Email</span>';
		elseif(get_user_by_email($email))
			$errors['email'][] = '<span data-fragment="7">You have already signed up. We will be in touch shortly.</span>';
		//Offer Validate
		$password = (string)trim($fields['password']);
		if(empty($password) || strlen($password)<6)
			$errors['password'][] = '<span data-fragment="12">Password is too short!</span>';
		$json['errors'] = $errors;
		$json['success'] = empty($errors['email']) && empty($errors['password']);
		if($json['success'])
		{
			$user_login = 'user.'.time();
			$user_id = wp_insert_user([
				'user_login'=> $user_login,
				'user_pass' => $password,
				'user_email' => $email,
				'role' => self::SHELTER_ROLE
			]);
			wp_set_current_user( $user_id, $user_login );
        	wp_set_auth_cookie( $user_id );
        	do_action( 'wp_login', $user_login );
		}
		return $json;
	}
	
	private function cuLang($json)
	{
		$fields = $_REQUEST[self::NAME]['Lang'];
		$errors = ['name'=>[],'lookup'=>[]];
		/**
		 * Validate Fields
		 */
		//Name Validation
		$name = trim($fields['name']);
		if(empty($name))
			$errors['name'][] = '<span class="console-fieldname">Language</span> cannot be empty';
		$display = trim($fields['display']);
		if(empty($display))
			$display = $name;
		//Lookup Validation
		$lookups = [];
		foreach($fields['start'] as $idx=>$s_ip)
		{
			$e_ip = $fields['end'][$idx];
			if(!filter_var($s_ip, FILTER_VALIDATE_IP) || !filter_var($e_ip, FILTER_VALIDATE_IP))
			{
				$errors['lookup'][] = '<span class="console-fieldname">Lookup</span> value is not valid';
				break;
			}
			$lookups[] = [$s_ip,$e_ip];
		}
		$json['errors'] = $errors;
		$json['success'] = empty($errors['name']) && empty($errors['lookup']);
		/**
		 * Enter If 0 errors
		 */
		if($json['success']):
			$slug = sanitize_title($name);
			$ouput = [$slug=>[]];
			if(!isset($this->option['Langs']))
				$this->option['Langs'] = [];
			$translations = isset($this->option['Langs'][$slug])?$this->option['Langs'][$slug]['translations']:[];
			$lang = ['name'=>$name,'lookup'=>$lookups,'translations'=>$translations,'display'=>$display];
			$this->option['Langs'][$slug] = $lang;
			include "page/lang-row.php";
			$output = ob_get_clean();
			update_option(self::NAME."_option", json_encode($this->option));
			$json['content'] = $output;
			$json['context'] = $slug;
		endif;
		return $json;
	}
	
	/**
	 * Translates a Language
	 * 
	 * @param	array	$json	JSON response sent to the browser - Pre-prepared by main Ajax Function
	 * @return			JSON response sent to the browser
	 */
	private function translateLang($json)
	{
		$fields = $_REQUEST[self::NAME]['Lang']['Translation'];
		$slug = $fields['slug'];
		if(!isset($this->option['Langs'][$slug]))
		{
			$json['errors']['slug'][] = 'Language not found!'; 
		}
		else
		{
			$this->option['Langs'][$slug]['translations'] = $fields['fragment'];
			update_option(self::NAME."_option", json_encode($this->option));
			$json['success'] = true;
		}	
		return $json;
	}
	
	/**
	 * Deletes a Language
	 * 
	 * @param	array	$json	JSON response sent to the browser - Pre-prepared by main Ajax Function
	 * @return			JSON response sent to the browser
	 */
	private function delLang($json)
	{
		$lang = sanitize_title($_REQUEST['context']);
		if(isset($this->option['Langs'][$lang]))
		{
			unset($this->option['Langs'][$lang]);
			update_option(self::NAME."_option", json_encode($this->option));
			$json['success'] = true;
		}	
		return $json;
	}
	
	/**
	 * Utility function - Renders an IcoMoon Icon
	 * 
	 * @param	string			$icon		IcoMoon Icon suffix
	 * @param	string|boolean	$text		Text to be appened after the Icon's HTML <tag>. Will be separated by a HTML Space. Default: false (no text appeneded)
	 * @param	string|boolean	$tip		Tooltip for the Icon. Default: false (No Tooltip)
	 * @param	array			$options	List of HTML Attributes for the Icon's HTML <tag>
	 * @param	string			$tag		HTML Tag to be used for the Icon. This is ignore if $tip is set to false
	 * @return	string			HTML of Icon
	 */
	public function icon($icon,$text=false,$tip=false,$options=[],$tag = 'span')
	{
		 $iconTag = $tip ? 'span' : $tag;
		 $html = "<$iconTag class='icon-$icon".(isset($options['class'])?" ".$options['class']:"")."'";
		 if($tip)
		 	$options['title'] = $tip;
		 foreach($options as $attr=>$val)
		 {
		 	if($attr != 'class')
				$html .=" $attr='$val'";
		 }
		 
		 $html .= "></$iconTag>".($text?"&nbsp;$text":"");
		 
		 if($tip)
		 {
		 	$html = "<$tag class='tip' title='$tip'>$html</$tag>";
		 }
		 return $html;
	}
	
	public static function langWidget()
	{
		global $RefugeeBnb;
		$option = (array)json_decode(get_option(self::NAME."_option"),true);
		$langs = $option['Langs'];
		$langDefaults = $RefugeeBnb->translationFragments;
		include_once "views/lang-widget.php";
	}
	
	public static function render()
	{
		include_once "views/index.php";
	}
}
$RefugeeBnb = new RefugeeBnb();