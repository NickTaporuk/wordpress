<?php
/**
 * @package WordPress
 * @subpackage Chocolate
 */

if ( !isset($GLOBALS['is_contacts']) )
	$GLOBALS['is_contacts'] = 0;
if ( !isset($GLOBALS['nostrip']) )
	$GLOBALS['nostrip'] = 0;

$options = get_option(LANGUAGE_ZONE."_theme_options");
?>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/html5reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/style.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/skin.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/wp.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/shortcodes.css" />

<?php if ( ! dt_get_theme_options( 'turn_off_responsivness' ) ): ?>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/media.css" />

<?php endif; ?>

<?php if( defined('GAL_HOME') || is_page_template('home-slider.php') || is_page_template('home-3d.php') || is_page_template('home-static.php')): ?>
	<link href="<?php echo get_template_directory_uri(); ?>/css/home.css" rel="stylesheet" type="text/css" />
	<?php if ( ! dt_get_theme_options( 'turn_off_responsivness' ) ): ?>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/home-media.css" />		
	<?php endif; ?>
<?php endif; ?>

<?php if ( isset($options['favicon']) && $options['favicon'] ): ?>
	<?php
	$up_dir = wp_upload_dir();
	$dir = $up_dir['baseurl'].'/dt_uploads/';
	?>
	<link rel="shortcut icon" href="<?php echo $dir.$options['favicon'];//echo get_template_directory_uri().'/cache/'.$options['favicon']; ?>" />
<?php endif; ?>

<?php
if (isset($options['ga_code'])) {
	echo $options['ga_code'];
}
?>

<?php
// add like buttons scripts
/*
if( (is_page_template('gallery-plus.php') && dt_get_theme_options('enable_in_album')) ||
	(is_page_template('gallery-plus-one-level.php') && dt_get_theme_options('enable_in_photos')) ||
	(is_page_template('blog.php') && dt_get_theme_options('enable_in_blog')) )
{
	$use_custom = dt_get_theme_options('use_custom_likes');

	if( is_lb_enabled('twitter') || $use_custom )
		add_action('wp_head', 'add_twitter_scripts', 99);

	if( is_lb_enabled('faceboock') || $use_custom )
		add_action('dt_after_body_begin', 'add_faceboock_scripts', 99);

	if( is_lb_enabled('google_plus') || $use_custom )
		add_action('wp_head', 'add_google_scripts', 99);
}
*/
?>

<?php get_template_part('demo'); ?>
