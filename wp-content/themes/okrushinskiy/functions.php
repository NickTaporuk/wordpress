<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 12.01.15
 * Time: 22:56
 */
function enqueue_styles() {
    wp_enqueue_style( 'style', get_stylesheet_uri());
    wp_register_style('font-style', 'http://fonts.googleapis.com/css?family=Oswald:400,300');
    wp_enqueue_style( 'font-style');
    wp_enqueue_style(  get_template_directory_uri().'/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_scripts () {
    wp_register_script('html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js');
    wp_enqueue_script('html5-shim');
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');