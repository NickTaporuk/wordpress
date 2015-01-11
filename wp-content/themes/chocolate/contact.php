<?php
/* Template Name: Contact */
?>
<?php
global $is_contacts;
$is_contacts=1;
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php get_template_part( 'loop' , 'post' ); ?>
<?php get_footer(); ?>
