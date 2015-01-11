<?php

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- WooTumblogTaxonomy Class
-- WooTumblogTaxonomy()
-- woo_tumblog_create_initial_taxonomy_terms()
-- woo_tumblog_restrict_manage_posts()
-- woo_tumblog_posts_where()

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* WooTumblogTaxonomy Class */
/*-----------------------------------------------------------------------------------*/
	
class WooTumblogTaxonomy {
	
	/*-----------------------------------------------------------------------------------*/
	/* Constructor */
	/*-----------------------------------------------------------------------------------*/
	function WooTumblogTaxonomy() {
		
		// Register custom taxonomy
		register_taxonomy(	"tumblog", 
							array(	"post"	), 
							array (	"hierarchical" 		=> true,
									"label" 			=> "Post Formats", 
									'labels' 			=> array(	'name' 				=> __('Post Formats'),
																	'singular_name' 	=> __('Post Formats'),
																	'search_items' 		=> __('Search Post Formats'),
																	'popular_items' 	=> __('Popular Post Formats'),
																	'all_items' 		=> __('All Post Formats'),
																	'parent_item' 		=> __('Parent Post Formats'),
																	'parent_item_colon' => __('Parent Post Formats:'),
																	'edit_item' 		=> __('Edit Post Format'),
																	'update_item'		=> __('Update Post Format'),
																	'add_new_item' 		=> __('Add New Post Format'),
																	'new_item_name' 	=> __('New Post Format Name')	), 
									'public' 			=> true,
									'show_ui' 			=> true,
									'show_in_nav_menus' => false,
									"rewrite" 			=> true	)
							);
							
		// Custom Taxonomy Filters
		add_action('restrict_manage_posts', array(&$this, 'woo_tumblog_restrict_manage_posts'));
		add_filter('posts_where', array(&$this, 'woo_tumblog_posts_where'));
							
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* Create Initial Taxonomy Terms */
	/*-----------------------------------------------------------------------------------*/
	
	function woo_tumblog_create_initial_taxonomy_terms() {
		
		$tumblog_items = array(	__('articles','woothemes')	=> __('Articles','woothemes'),
								__('images','woothemes') 	=> __('Images','woothemes'),
								__('audio','woothemes') 	=> __('Audio','woothemes'),
								__('video','woothemes') 	=> __('Video','woothemes'),
								__('quotes','woothemes')	=> __('Quotes','woothemes'),
								__('links','woothemes') 	=> __('Links','woothemes')
								);
		$taxonomy = 'tumblog';
		//loop and create terms
		foreach ($tumblog_items as $key => $value) {
			$id = term_exists($key, $taxonomy);
			if ($id > 0) {
		
			} else {
				$term = wp_insert_term($value, $taxonomy);
				if ( !is_wp_error($term) ) {
					update_option('woo_'.$key.'_term_id',$term['term_id']);
				}
			}
		}
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* Manage Posts Custom Filter Drop Down */
	/*-----------------------------------------------------------------------------------*/
	
	function woo_tumblog_restrict_manage_posts() {
	   return;
    ?>
        <form name="tumblog_attachmentform" id="tumblog_attachmentform" action="" method="get">
            <fieldset>
            <?php
				//Tumblogs
				$category_ID = $_GET['tumblog_names'];
            	if ($category_ID > 0) {
            		//Do nothing
            	} else {
            		$category_ID = 0;
            	}
            	$dropdown_options = array	(	
            								'show_option_all'	=> __('View all Tumblogs'), 
            								'hide_empty' 		=> 0, 
            								'hide_if_empty'		=> 1,
            								'hierarchical' 		=> 1,
											'show_count' 		=> 0, 
											'orderby' 			=> 'name',
											'name' 				=> 'tumblog_names',
											'id' 				=> 'tumblog_names',
											'taxonomy' 			=> 'tumblog', 
											'selected' 			=> $category_ID
											);
				wp_dropdown_categories($dropdown_options);
            ?>
            <input type="submit" name="submit" value="<?php _e('Filter') ?>" class="button" />
        </fieldset>
        </form>
    <?php
	}

	/*-----------------------------------------------------------------------------------*/
	/* Manage Posts Custom Filter Query Addon */
	/*-----------------------------------------------------------------------------------*/
	
	function woo_tumblog_posts_where($where) {
	   return $where;
    	if( is_admin() ) {
        	global $wpdb;
        	if (isset($_GET['tumblog_names'])) {
        		$tumblog_ID = $_GET['tumblog_names'];
			} else {
				$tumblog_ID = 0;
			}
        	if ( ($tumblog_ID > 0) ) {

				$tumblog_tax_names =  &get_term( $tumblog_ID, 'tumblog' );
				$string_post_ids = '';
 				//tumblogs
				if ($tumblog_ID > 0) {
					$tumblog_tax_name = $tumblog_tax_names->slug;
					$tumblog_myposts = get_posts('nopaging=true&tumblog='.$tumblog_tax_name);
					foreach($tumblog_myposts as $post) {
						$string_post_ids .= $post->ID.',';
					}
				}
			
 				$string_post_ids = chop($string_post_ids,',');
   				$where .= "AND ID IN (" . $string_post_ids . ")";
			}
    	}
    	return $where;
	}
	
}

?>
