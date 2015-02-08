<?php


if ( function_exists('register_sidebar') )
    register_sidebar(array(
    	'name' => 'Sidebar Left',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
    	'name' => 'Sidebar Right',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
?>