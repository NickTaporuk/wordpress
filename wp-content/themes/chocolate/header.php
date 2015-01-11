<?php
/**
 * @package WordPress
 * @subpackage Chocolate
 */ 
global $options;
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> style="<?php
	if ( get_demo_option( 'bg1' ) ) {
		$img = 'url(' . get_template_directory_uri() . get_demo_option( 'bg1' ) . ')';
	} else {
		$img = 'none';
	}

	if(!DEMO && $options['custom_bg1']) {
		//$img = '/cache/'.$options['custom_bg1'];
		$up_dir = wp_upload_dir();
		$dir = $up_dir['baseurl'].'/dt_uploads/';
		$img = 'url(' . $dir . $options['custom_bg1'] . ')';
	}

	echo 'background-color: ' . get_demo_option('bgcolor1') . '; ';
	echo 'background-image: ' . $img . '; ';
	
	if ( 'none' != $img ) {
		if (get_demo_option('bg1_repeat_x') && get_demo_option('bg1_repeat_y')) 
			echo 'background-repeat: repeat; ';
		elseif (get_demo_option('bg1_repeat_x')) 
			echo 'background-repeat: repeat-x; ';
		elseif (get_demo_option('bg1_repeat_y')) 
			echo 'background-repeat: repeat-y; ';
		else
			echo 'background-repeat: no-repeat; ';
		
		if (get_demo_option('bg1_fixed')) 
			echo 'background-attachment: fixed; ';
		if (get_demo_option('bg1_center')) 
			echo 'background-position: center 0; ';
	}
?>">
<head>



<?php if ( ! dt_get_theme_options( 'turn_off_responsivness' ) ) : ?>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<?php endif; ?>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php bloginfo('name'); ?> <?php wp_title( '|', true, 'left' ); ?></title>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php
   get_template_part( 'header' , 'dt' );
?>

<?php wp_head(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/cufon-yui.js"></script>

<?php if ($options['cufon_enabled']): ?>

<?php if( !DEMO && dt_get_theme_options('custom_cufon') ):
$u_dir = wp_upload_dir();
?>

<script type="text/javascript" src="<?php echo $u_dir['baseurl']; ?>/dt_uploads/<?php echo dt_get_theme_options('custom_cufon'); ?>"></script>

<?php else: ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/fonts/<?php echo get_demo_option('font'); ?>.font.js"></script>

<?php endif; ?>


<script type="text/javascript">
Cufon('#nav > li > a', {
  color: '-linear-gradient(#f5f2eb, 0.5=#f5f2eb, 0.8=#acaaa4, #acaaa4)', textShadow: '-1px -1px #000'/*,
  hover: {
	color: '-linear-gradient(#aba197, 0.5=#aba197, 0.8=#887d72, #887d72)', textShadow: '-1px -1px #000'
  }*/
});
Cufon('#nav > li.current_page_item > a, #nav > li.current-menu-item > a', {
  color: '-linear-gradient(#aba197, 0.5=#aba197, 0.8=#887d72, #887d72)', textShadow: '-1px -1px #000'
});

jQuery(document).ready(function ($) {
   var _n = 0;
   $('.nav > ul > li > a').each(function () {
      _n++;
      var idd = "a"+_n;
      var ee = $(this);
      ee.attr("id", idd);
      ee.hover(function () {
         Cufon.replace( "#"+idd , {
            color: '-linear-gradient(#aba197, 0.5=#aba197, 0.8=#887d72, #887d72)', textShadow: '-1px -1px #000'
         });
         Cufon.now();
      }, function () {
         if (
            $(this).parent().hasClass('current_page_item') ||
            $(this).parent().hasClass('current-menu-item')
         )
            return;
         Cufon.replace( "#"+idd , {
            color: '-linear-gradient(#f5f2eb, 0.5=#f5f2eb, 0.8=#acaaa4, #acaaa4)', textShadow: '-1px -1px #000'
         });
         Cufon.now();
      });
   });
});

Cufon('.widget .header, .folio_caption, .folio_just_caption', {
  fontWeight: 'bold',
  color: '-linear-gradient(#f5f2eb, 0.5=#f5f2eb, 0.8=#acaaa4, #acaaa4)', textShadow: '-1px -1px #000'
});
Cufon('._cf, .article h1, .article h2, .article h3, .article h4, .article h5, .article h6', {
  fontWeight: 'bold',
  color: '-linear-gradient(#473e2b, 0.4=#473e2b, #1c1a19)', textShadow: '0 1px #fff',
  hover: {
	color: '-linear-gradient(#60543a, 0.4=#60543a, #433e3c)', textShadow: '0 1px #fff'
  }
});
Cufon('.quote_author', {
  fontWeight: 'bold',
  color: '#221f1c', textShadow: '1px 1px #fff'
});
Cufon('.paginator li', {
  fontWeight: 'bold',
  color: '-linear-gradient(#f5f2eb, #bfbcb7)', textShadow: '-1px -1px #000'
});
Cufon('.paginator li.act', {
  fontWeight: 'bold',
  color: '#857d74', textShadow: '-1px -1px #000'
});
Cufon('.go_up', {
  fontWeight: 'bold',
  color: '-linear-gradient(#f5f2eb, #bfbcb7)', textShadow: '-1px -1px #000'
});
Cufon('.article_footer .header', {
  fontWeight: 'bold',
  color: '-linear-gradient(#f5f2eb, 0.5=#f5f2eb, 0.8=#acaaa4, #acaaa4)', textShadow: '-1px -1px #000'
});
</script>
<?php endif; ?>

<script type="text/javascript">
<?php $options = get_option(LANGUAGE_ZONE."_theme_options"); ?>
	var menu_cl=<?php echo intval($options['menu_cl']); ?>;
</script> 

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.transit.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.masonry.min.js"></script>

<!-- CUSTOM -->

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>
<?php if( defined('GAL_HOME') ): ?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.wipetouch.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/gallery.js"></script>
<?php endif; ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/custom.css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/placeholder/jquery.placeholder.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/validator/jquery.validationEngine.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/validator/z.trans.en.js"></script> 
<link href="<?php echo get_template_directory_uri(); ?>/js/plugins/validator/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/highslide-full.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/highslide.config.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/highslide.mobile.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/highslide.css" />


<?php if( is_page_template('home-video.php') ): ?>

	<?php
	global $jwplayer_flag; 
	$jwplayer_flag = file_exists( get_template_directory().'/js/jwplayer/jwplayer.js' );
	?>
	<?php if ( ! dt_get_theme_options( 'turn_off_responsivness' ) ): ?>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/home-media.css" />		
	<?php endif; ?>
	
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/home.css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.wipetouch.js"></script>
	<?php if($jwplayer_flag): ?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jwplayer/jwplayer.js" charset="utf-8"></script>
	<?php else: ?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jplayer/jquery.jplayer.min.js" charset="utf-8"></script>
	<?php endif; ?>
	
	
<?php elseif( is_page_template('home-slider.php') ): ?>

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/supersized.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/supersized.shutter.css" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/supersized.3.2.7.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.wipetouch.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/supersized.shutter.js"></script>
	<?php get_template_part('home-slider_header'); ?>
	
<?php elseif( is_page_template('home-3d.php') ): ?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/plugins/3d-slider/slider3d.css" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.wipetouch.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/3d-slider/jquery.ui.core.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/3d-slider/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/3d-slider/jquery.ui.slider3d-depthumb.js"></script>
	<?php get_template_part('home-slider_header'); ?>
	
<?php elseif( is_page_template('home-static.php') ): ?>

	<?php
	if( has_post_thumbnail() ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
	}else {
		$img[0] = get_template_directory_uri().'/images/noimage.jpg';
	}
	?>
	
	<!--<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/supersized.core.3.2.1.js"></script>-->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/supersized.css" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/supersized.3.2.7.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.wipetouch.js"></script>
	
	<script type="text/javascript">
		jQuery(function($){
			setTimeout(function() {
				$.supersized({
					slides  :  	[ {image : '<?php echo $img[0]; ?>', title : '<?php the_title(); ?>'} ]
				});
			}, 500);
		});
	</script>
	
<?php endif; ?>


<script>
	// DO NOT REMOVE!
	// b21add52a799de0d40073fd36f7d1f89
	hs.graphicsDir = '<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/graphics/';
</script>
<!-- END CUSTOM -->

<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="css/old_ie.css" />
<![endif]-->

<script>
	// DT: Here goes trigger to show widgets in mobile layout 
	window.moveWidgets = <?php echo dt_get_theme_options( 'hide_sidebar_in_mobile' ) ? 'false' : 'true'; ?>;
	
	window.ResizeTurnOff = <?php echo dt_get_theme_options( 'turn_off_responsivness' ) ? 'true' : 'false'; ?>;
</script>

</head>
<?php
$class = '';
if( is_page_template('home-slider.php') || is_page_template('home-3d.php') ) {
	$class = 'home';
}
?>
<body <?php body_class($class); ?> style="<?php
	// new
	if ( get_demo_option('bg2') ) {
		$img = 'url(' . get_template_directory_uri().get_demo_option('bg2') . ');';
	} else {
		$img = 'none';
	}

	if(!DEMO && $options['custom_bg2']) {
		//$img = get_template_directory_uri().'/cache/'.$options['custom_bg2'];
		$up_dir = wp_upload_dir();
		$dir = $up_dir['baseurl'].'/dt_uploads/';
		$img = 'url(' . $dir.$options['custom_bg2'] . ');';
	}
	
	echo 'background-image: ' . $img;
	
	if ( 'none' != $img ) {
		if (get_demo_option('bg2_repeat_x') && get_demo_option('bg2_repeat_y')) 
			echo 'background-repeat: repeat; ';
		elseif (get_demo_option('bg2_repeat_x')) 
			echo 'background-repeat: repeat-x; ';
		elseif (get_demo_option('bg2_repeat_y')) 
			echo 'background-repeat: repeat-y; ';
		else
			echo 'background-repeat: no-repeat; ';
		
		if (get_demo_option('bg2_fixed')) 
			echo 'background-attachment: fixed; ';
		
		if (get_demo_option('bg2_center')) 
			echo 'background-position: center 0; '; 
	}
?>">

<?php do_action('dt_after_body_begin'); ?>

<?php /* if(!is_page_template('home-static.php')) : */ ?>
	<div id="bg">
	
		<div id="header-mobile">
		<!-- DT: mobile logo goes here: begin -->
			<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" id="logo-mobile">
			  <?php if (isset($options['mobile_logo']) && $options['mobile_logo']): ?>
				 <img src="<?php
					$up_dir = wp_upload_dir();
					$dir = $up_dir['baseurl'].'/dt_uploads/';
					$url = $dir.$options['mobile_logo'];
					echo esc_url($url);
				 ?>" alt="<?php wp_title(); ?>" />
			  <?php else: ?>
				 <img src="<?php echo get_template_directory_uri(); ?>/images/logo-mobile.png" alt="<?php wp_title(); ?>" />
			  <?php endif; ?>
			</a>
		<!-- DT: mobile logo goes here: end -->
			<?php
			dt_menu( array(
				'menu_wraper' 		=> '<select>%MENU_ITEMS%</select>',
				'menu_items'		=> '<option data-level="%DEPTH%" value="%ITEM_HREF%"%ACT_CLASS%>%ITEM_TITLE%</option>%SUBMENU%',
				'submenu' 			=> '%ITEM%',
				'location'			=> 'primary',
				'act_class'			=> ' selected',
				'depth'				=> 3 
			) );
			?>
		</div>

<?php /* endif; */ ?>
<?php get_template_part( 'top' ); ?>
<?php
$class = '';
if( is_page_template('home-video.php') ) {
	if( $jwplayer_flag ) {
		$class = ' class="video jw"';
	}else {
		$class = ' class="video"';
	}
}elseif( is_page_template('home-slider.php') ) {
	$class = ' class="slide"';
}elseif( is_page_template('home-static.php') ) {
	$class = ' class="static"';
}elseif( is_page_template('home-3d.php') ) {
	$class = ' class="slide slider-3d"';
}
?>
<div id="holder"<?php echo $class; ?>>