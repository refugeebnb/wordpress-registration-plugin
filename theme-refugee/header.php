<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
    <title>
    	<?php
        if ( is_single() ) {bloginfo('name'); print ' | '; single_post_title(); }       
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description');}
        elseif ( is_page() ) {bloginfo('name'); print ' | '; single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . esc_html($s); ThemeController::get_page_number(); }
        elseif ( is_author() ) {
        		 bloginfo('name'); print ' | Contributions by '.get_the_author();
		}
        elseif ( is_archive() ) { bloginfo('name'); print ' | '; single_cat_title();}
		elseif ( is_404() ) { bloginfo('name'); print ' | '; bloginfo('description'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); ThemeController::get_page_number(); }
    	?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Oswald' type='text/css' />
	<link rel="shortcut icon" href="<?= get_stylesheet_directory_uri(); ?>/favicon.ico?v=2" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
    <?php wp_head();?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		//ga('create', 'UA-65056538-1', 'auto');
		//ga('send', 'pageview');
	</script>
</head>
<body <?php body_class(); ?>>
	<header>
		<div>
			<div id="large-affix">
				<div class='navbar container-fluid navbar-fixed-top'>
		    		<div class="navbar-header">
			            <a class="logo-xs oswald" href="<?php bloginfo("url");?>"><?= get_bloginfo("title")?></a>
			       		<div class="lang-selector pull-right">
	                    	<?= RefugeeBnb::langWidget();?>
	        			</div>
			       	</div>
		    	</div>
		    </div>
	    </div>
	</header>
	<div class="hero-image" style="background-image: url('<?= get_stylesheet_directory_uri(); ?>/img/bg-<?= rand(1,3)?>.png')"></div>
