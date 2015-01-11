<?php

if (file_exists(dirname(__FILE__)."/install-theme-ms.php")) require_once(dirname(__FILE__)."/install-theme-ms.php"); // обработка загрузки демо данных morestyle\n

/**
 * @package WordPress
 * @subpackage Chocolate
 */

/* Set the content width based on the theme's design and stylesheet. */
if ( ! isset( $content_width ) )
	$content_width = 700;

/* Set up theme defaults and registers support for various WordPress features. */
if ( ! function_exists( 'dt_setup' ) ):

   function include_files_in_dir($dir, $no_more=FALSE)
   {
      $dir_init = $dir;
      $dir = dirname(__FILE__).$dir;
      
      if (!file_exists($dir))
         throw new Exception("Folder $dir does not exist");
         
      $files = array();
         
      if ($handle = opendir( $dir )) {
          while (false !== ($file = @readdir($handle))) {
              if ( is_dir( $dir.$file ) && !preg_match('/^\./', $file) && !$no_more )
              {
                 include_files_in_dir($dir_init.$file."/", TRUE);
              }
              else
              {
                 if ( preg_match('/^[^~]{1}.*\.php$/', $file) ) {
                     $files[] = $dir.$file;
                 }
              }
          }
          @closedir($handle);
      }      
      
      sort($files);
      
      foreach ($files as $file)
         include_once $file;
   }

   function dt_setup() {
	   // This theme uses post thumbnails
	   add_theme_support( 'post-thumbnails' );
	   set_post_thumbnail_size( 180, 180 ); // default Post Thumbnail dimensions   
	   add_image_size( 'dt-l-thumb', 700, 9999, false ); // Large Post Thumbnail
	   add_image_size( 'dt-m-thumb', 460, 9999, false ); // Medium Post Thumbnail
	   add_image_size( 'dt-s-thumb', 220, 9999, false ); // Small Post Thumbnail

	   // This theme styles the visual editor with editor-style.css to match the theme style.
	   add_editor_style();

	   // Add default posts and comments RSS feed links to head
	   add_theme_support( 'automatic-feed-links' );

	   // Make theme available for translation
	   // Translations can be filed in the /languages/ directory
	   load_theme_textdomain( 'dt', TEMPLATEPATH . '/languages' );
	   $locale = get_locale();
	   $locale_file = TEMPLATEPATH . "/languages/$locale.php";
	   if ( is_readable( $locale_file ) )
		   require_once( $locale_file );

	   // This theme uses wp_nav_menu() in one location.
	   add_theme_support('nav_menus');
	   register_nav_menus( array(
		   'primary' => __( 'Primary Navigation', 'dt' ),
	   ) );
	
	   // Include functions/*.php
	   include_files_in_dir("/functions/");

	   // Include settings/*.php
	   include_files_in_dir("/settings/");
	   
	   // Include plugins/*/*.php
	   include_files_in_dir("/plugins/");
   }
   
endif;

add_action( 'init', 'dt_setup' );
add_action( 'after_setup_theme', 'dt_setup' );

function dt_register_jquery() {
	if( !is_admin() ){
		wp_deregister_script('jquery');
		wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"), false, '1.7.2');
		wp_enqueue_script('jquery');

		global $post;
    	$data = array(
	    	'ajaxurl'	    => admin_url( 'admin-ajax.php' ),
        	'post_id'       => isset($post->ID)?$post->ID:''
    	);
    	wp_localize_script( 'jquery', 'dt_ajax', $data );
	}
}
add_action('wp_enqueue_scripts', 'dt_register_jquery');

// add custom post type to search query
function filter_search($query) {
    if ($query->is_search) {
		$query->set('post_type', array('post', 'dt_gallery_plus', 'dt_portfolio'));
    };
    return $query;
};
add_filter('pre_get_posts', 'filter_search');

function dt_generate_contact_id() {
	static $id = 1;
	return $id++;
}

function dt_admin_menu() {
    global $menu;
    global $submenu;
	if( isset($submenu['edit.php'][17]) && 'edit-tags.php?taxonomy=tumblog' == $submenu['edit.php'][17][2])
		unset( $submenu['edit.php'][17]);
}
add_action( 'admin_menu', 'dt_admin_menu' );
//add_action( 'user_admin_menu', 'dt_admin_menu' );

function dt_get_theme_options( $option = '' ) {
	$options = get_option( LANGUAGE_ZONE.'_theme_options' );
	
	if( !$options )
		return false;
		
	if( $option ) {
		if( isset($options[$option]) )	
			return $options[$option];
		return false;
	}

	return $options;	
}

function dt_get_images_for_sliders( $box_name = '' ) {
	global $dt_options, $post, $wpdb;
	$dt_options = $images = array();
	$options = get_post_meta( $post->ID, 'dt_'.$box_name.'_options', true );
	
	if( !$options ) return array();
	
	$dt_options = $options;
	$arr = isset($options['show_'. $box_name. '_'. $options['show']])?$options['show_'. $box_name. '_'. $options['show']]:'all';
	$args = array(
		'post_type' 		=>'attachment', 
		'post_mime_type'	=>'image',
		'post_status' 		=>'inherit',
		'orderby'			=>'menu_order',
		'order'				=>'ASC',
		'posts_per_page'	=>-1
	);
	$query_str = sprintf( 'SELECT `ID` FROM %s WHERE `post_type`="%s" AND post_status="publish"', $wpdb->posts, 'main_slider' );
	if ( is_array($arr) ) {
		$query_str .= ' AND ID';
		if ( 'except' == $options['show'] ) {
			$query_str .= ' NOT';
		}
		$query_str .= sprintf( ' IN(%s)', implode( ',', $arr ) );
	}
	$query_str .= ' ORDER BY post_date DESC';
	// send query to filter
	dt_parent_where_query( $query_str );

	add_filter( 'posts_where' , 'dt_posts_parents_where' );
	$slides = new Wp_Query( $args );
	remove_filter( 'posts_where' , 'dt_posts_parents_where' );
	// process images
	foreach( $slides->posts as $slide ) {
		$image = wp_get_attachment_image_src($slide->ID, 'large');
		$small_image = '';

		if ( isset($image[0]) ) {
			$tmp_src = dt_clean_thumb_url($image[0]);
			$small_image = esc_attr(get_template_directory_uri()."/thumb.php?src={$tmp_src}&w=102&h=62zc=1");
		}

		$hide_title = get_post_meta( $slide->ID, '_dt_slider_hdesc', true );

		$title = '';
		if( !$hide_title )
			$title = apply_filters('the_title', $slide->post_excerpt);
		
		$images[] = <<<HDOCK
		{image : '{$image[0]}', title : '{$title}', thumb : '{$small_image}', url : ''}
HDOCK;
	}
	
	return array( 'images' => $images, 'options' => $options );
}

include( TEMPLATEPATH . '/dt-pagenavi.php');

	require_once("widgets/theme-notifier.php");
?>
