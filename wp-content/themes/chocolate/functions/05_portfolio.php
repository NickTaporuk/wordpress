<?php

add_action( 'init', 'create_portfolio_type' );
function create_portfolio_type() {
	register_post_type( 'dt_portfolio',
		array(
			'labels' => array(
				'name' => __( 'Portfolio' ),
				'singular_name' => __( 'Work' ),
				'edit_item' => __('Edit Work'),
				'add_new_item' => __('Add New Work'),
				'new_item_name' => __('New Work Name'),
			),
        	'public' => true,
        	'exclude_from_search' => true,
        	'show_ui' => true,
        	'taxonomies' => array('dt_portfolio'),
        	'capability_type' => 'post',
        	'hierarchical' => false,
        	'rewrite' => array('slug' => 'portfolio'),
			'has_archive' => true,
			'menu_icon' => get_template_directory_uri() . '/images/portfolio.png',
			'supports' => array(
		      'title', 
		      'thumbnail', 
		      'editor',
		      'comments',
		      'trackbacks',
		      'revisions',
		      'custom-fields',
		      'excerpt'
			)
		)
	);

	register_taxonomy('dt_portfolio_cat', array (
         0 => 'dt_portfolio',
      ),
      array(
         'hierarchical' => true, 
			'labels' => array(
				'name' => __( 'Categories' ),
				'singular_name' => __( 'Category' ),
				'popular_items' => __( 'Popular Categories' ),
				'edit_item' => __('Edit Category'),
				'add_new_item' => __('Add New Category'),
				'new_item_name' => __('New Category Name'),
			),
         'show_ui' => true,
         'query_var' => true,
         'rewrite' => array('slug' => 'category'),
         'singular_label' => 'Categories',
      )
   );
}



?>
