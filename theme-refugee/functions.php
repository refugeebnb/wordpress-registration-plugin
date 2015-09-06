<?php
class ThemeController{
	
	static $menu = array(
		'top-menu' => 'Top Menu',
	);  
	public static $social = array(
		"fb"=>"fb",
		"tw"=>"tw",
		"pin"=>"pin",
	);
	public static $author = array(
		"company" => "link3",
		"facebook"=>"facebook",
		"twitter"=>"twitter2",
		"googleplus"=>"googleplus5",
		"instagram"=>"instagram2",
		"pinterest"=>"pinterest3",
		"linkedin"=>"linkedin2"
	);
	const ajax = "RefugeeFrontend";
	function ThemeController()
	{
		if(!session_id())
		{
			session_start();
		}
		define("CONTEXT_URL",get_bloginfo('template_url')."/");
		define("UPLOAD_URL",get_bloginfo('url')."/wp-content/uploads/");
		define("GALLERY_URL",UPLOAD_URL.APPLICATION_NAME);
		add_action( 'wp_ajax_'.self::ajax, array(&$this,'ajax'));
		add_action( 'wp_ajax_nopriv_'.self::ajax, array(&$this,'ajax'));
		add_action( 'wp_ajax_'.'SearchBlog', array(&$this,'search'));
		add_action( 'wp_ajax_nopriv_'.'SearchBlog', array(&$this,'search'));
		self::api();
	}
	
	public function search()
	{
		$args = $_REQUEST;
		if(isset($args['action']))
			unset($args['action']);
		if(!isset($args['post_type']))
			$args['post_type'] = 'post';
		$query = new WP_Query($args);
		$posts = [];
		while($query->have_posts())
		{
			$query->the_post();
			$posts[get_the_ID()] = "<a href='".get_permalink()."' target='_blog'>".get_the_title()."</a>";
		}
		echo json_encode($posts);
		exit;
	}
	
	public function ajax()
	{
		$json = array('msg' => '','flag'=>1);
		if(is_email($_POST['email']))
		{
			$response = MailChimp::put(array(array($_POST['email'],'','')),false,true,true);
			if($response['error_count'] > 0)
			{
				$json['msg'] = self::alert("An error occurred! Sorry, we couldn't sign you on at this point!");
				$json['flag'] = 0;
			}
			elseif($response['add_count'] == 0 && $response['update_count'] ==1)
			{
				$json['msg'] = self::alert("Seems like we already had you on our list!","warning");
				$json['flag'] = 2;
			}
			else
			{
				$json['msg'] = self::alert("Thanks Champ for Subscribing! Exciting stuff coming your way!","info");
			}
		}	
		else
		{
			$json['msg'] = self::alert("Invalid email!"); 
			$json['flag'] = 0;
		}
		echo json_encode($json);
		exit;
	}
	
	static function alert($msg,$type="danger")
	{
		return "<div class='alert alert-$type'>".$msg."</div>";
	}
	
	static function ago()
	{
		$date = time() - strtotime(get_the_date( "Y/n/j H:i:s", get_the_ID() ));
		$date = intval($date/60);//Mins
		$verb = $date == 1?"min":"mins";
		if($date > 60)
		{
			$date = intval($date/60);//Hours
			$verb = $date == 1?"hour":"hours";
			if($date > 24)
			{
				$date = intval($date/24);//Days
				$verb = $date == 1?"day":"days";
				if($date > 30)
				{
					$days = $date;
					$date = intval($date/30);//Months
					$verb = $date == 1?"month":"months";
					if($date > 12)
					{
						$date = intval($days/365);//Years
						$verb = $date == 1?"year":"years";
					}
				}
			}
		}
		return $date." ".$verb." ago";
	}
	
	static function api()
	{
		register_nav_menus(self::$menu);
        wp_register_script('bootstrap', CONTEXT_URL."js/bootstrap.min.js",array('jquery','json2'));
        wp_register_script('jq-cookie', CONTEXT_URL."js/cookie.js",array('jquery','json2'));
        wp_register_script('jq-mw', CONTEXT_URL."js/mw.js",array('jquery','json2'));
        wp_register_script('theme-script', CONTEXT_URL."js/script.js",array('jquery','json2','jq-cookie','bootstrap','jq-mw'));
		if(!is_admin())
		{
			wp_enqueue_script('theme-script');
		}
	}
	
	static function img($name,$attrs=array(),$print=true)
	{
		$content = "<img src='".CONTEXT_URL."img/$name'";
		foreach($attrs as $attr=>$val)
		{
			if(!empty($val))
			{
				$content .="$attr='$val' ";
			}
		}
		$content .="/>";
		if(!$print)
		{
			return $content;
		}
		echo $content;
	}
	
	static function snippets($post_type,$template=false,$num = 3,$paged = false,$filter=array(),$echo=true,$template_args=false)
	{
		$args = array_merge( array(
			'post_type'=>$post_type,
			'posts_per_page' => $num,
			'post_status' => array('publish')
		),$filter);
		
		if($paged)
		{
			$current_page = max(1,get_query_var('paged'));
			$args['paged'] = $current_page;
		}
		
		$_html = ""; $body = ""; $feed = array();
		
		$articles = new WP_Query($args);
		if($articles->have_posts())
		{
			$template = !$template?$post_type:$template;
			$counter=0; $iter = 0;
			if(!$echo)
			{
				ob_start();
			}
			while($articles->have_posts())
			{
				$counter++;
				$articles->the_post();
				include "snippets/$template.php";
				$body .= $feed[] = ob_get_contents();
				ob_clean();
			}
			wp_reset_query();
			if(!$echo)
			{				
				 ob_end_clean();	
			}
			
			return array($counter,$_html,$articles,$body,$feed);	
		}
		else
		{
			wp_reset_query();
			return false;
		}		
	}
	
	static function get_page_number()
	{
		return get_query_var('paged');
	}
	
	static function breadcrumbs()
	{
		if(is_home() || is_front_page())
            return;
		the_post();
		echo "<ol class=\"breadcrumb\">
		      <li><a href='".get_bloginfo('url')."'>Home</a></li>";
		
		if(is_page())
           echo "<li>".get_the_title()."</li>";
		
        if(is_category())
            echo "<li>".get_category( get_query_var('cat'))->name."</li>";
        
        if(is_single())
        {
            $type = get_post_type();
            switch($type)
            {
                case 'post':
                    echo "<li>".get_the_category_list( ", ")."</li>";
                    break;
                case 'services':
                    echo "<li><a href=\"".get_bloginfo("url")."#services\">Services</a></li>";
                    break;
            }
            echo "<li>".get_the_title()."</li>";
        }
		echo '</ol>';
		
		rewind_posts();
	}
}
$t_tempalte = new ThemeController();
$AllAppOptions = (array)json_decode(get_option(RefugeeBnb::NAME.'_option'),true);
$AppOptions = $AllAppOptions['Setup'];
class MailChimp{
	 
	const ROOT_URL = "https://#dc.api.mailchimp.com/2.0/";
	
	private static function execute($call,$vars=array())
	{
		global $AppOptions;
		$url  = str_replace("#dc",$AppOptions['mc_domain'],self::ROOT_URL).$call.".json";
		$vars['apikey'] = $AppOptions['mc_api'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($vars));
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_VERBOSE, true);
		$result = curl_exec($ch);
		return json_decode($result,true);
	}
	
	public static function members($page=0,$limit=25)
	{
		return self::execute("lists/members",array("id"=>$AppOptions['mc_list'],
			'opts'=>array(
				'start' => $page,
				'limit' => $limit
			)
		));
	}
	
	public static function put($emails=array(),$optin=true,$update=true,$replace=true)
	{
		global $AppOptions;
		if(!empty($emails))
		{
			$vars = array(
				"id"=>$AppOptions['mc_list'],
				"batch" => array(),
				"double_optin" => $optin,
				"update_existing" => $update,
				"replace_interests" => $replace
			);
			
			foreach($emails as $user)
			{
				$vars['batch'][] = array(
					'email' => array(
						'email'=>$user[0]
					),
					"merge_vars" => array(
						'MERGE1' => $user[1],
						'MERGE2' => $user[2]
					)
				);
			}
			$response = self::execute("lists/batch-subscribe",$vars);
			return $response;
		}
		else{
			return false;
		}
	}
	
	public static function lists()
	{
		$lists = self::execute("lists/list");
		if($lists['total']>0)
		{
			foreach($lists['data'] as $list)
			{
				echo $list['id']." : ".$list['name']."<br />";
			}
		}
		else {
			echo "No lists found";
		}
		
	}
}

class BootStrapMenu extends Walker_Nav_Menu{
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' );
	    $classes = array('dropdown-menu dropdown-toggle');
	    $class_names = implode( ' ', $classes );
	    $output .= "\n" . $indent . '<ul class="' . $class_names . '" role="menu">' . "\n";
	}
}
function menu_set_dropdown( $sorted_menu_items, $args ) {
    $last_top = 0;
    foreach ( $sorted_menu_items as $key => $obj ) {
        // it is a top lv item?
        if ( 0 == $obj->menu_item_parent ) {
            // set the key of the parent
            $last_top = $key;
        } else {
            $sorted_menu_items[$last_top]->classes['dropdown'] = 'dropdown';
        }
    }
    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'menu_set_dropdown', 10, 2 );
function validate_gravatar($email) {
	// Craft a potential url and test its headers
	$hash = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers($uri);
	if (!preg_match("|200|", $headers[0])) {
		$has_valid_avatar = FALSE;
	} else {
		$has_valid_avatar = TRUE;
	}
	return $has_valid_avatar;
}
/* Change Excerpt length */
function custom_excerpt_length( $length ) {
   return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );