<?php
/*
Plugin Name: Lightbox Gallery
Plugin URI: http://wpgogo.com/development/lightbox-gallery.html
Description: Changes to the lightbox view in galleries.
Author: Hiroaki Miyashita
Version: 0.6.3
Author URI: http://wpgogo.com/
*/

/*  Copyright 2009 -2010 Hiroaki Miyashita

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

add_shortcode( 'gallery', 'sakura_lightbox_gallery' );

function dt_gallery_custom($attrs) {
   $output = "";
   
   global $post, $wp_query;
   
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 4,
		'size'       => 'large',
		'include'    => '',
		'exclude'    => '',
		'lightboxsize' => 'large',
		'meta'       => 'false',
		'class'      => 'gallery1',
		'nofollow'   => false,
		'from'       => '',
		'num'        => '',
		'title'		 => '',
		'page'       => get_query_var('page'),
		'before' => '<div class="gallery_pagenavi">' . __('Pages:',LANGUAGE_ZONE), 'after' => '</div>',
		'link_before' => '', 'link_after' => '',
		'next_or_number' => 'number', 'nextpagelink' => __('Next page', LANGUAGE_ZONE),
		'previouspagelink' => __('Previous page', LANGUAGE_ZONE), 'pagelink' => '%', 'pagenavi' => 1
	), $attrs));
   
	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}
	
	if ( count($attachments) == 0 ) return "";
	
	$cover = current($attachments);
	
	global $attachments_counter;
	$attachments_counter++;
	
   $pic = wp_get_attachment_image_src( $cover->ID , 'full' );
   
   //$pic = default_attachment($pic);
   
   $k = $pic[1] / $pic[2];
   
   $pic = $pic[0];
   
   $w = 220;
      
   $h = ceil($w / $k);

   $tmp_src = dt_clean_thumb_url($pic);
   $pic = get_template_directory_uri().'/thumb.php?src='.$tmp_src.'&amp;w='.$w.'&amp;h='.$h.'&amp;zc=1';

	if ( !empty($attrs["title"]) ) {
		$new_title = $attrs["title"];
	} else {
		$new_title = __('View all pictures', LANGUAGE_ZONE);
		$attrs["title"] = '';
	}
	
	$output .= '
      <div class="folio_box col_s for_post_'.$attachments_counter.'">
        <div class="folio" style="background: url('.$pic.') 0 0; height: '.$h.'px;">
  
          <div class="folio_mask mv_all">
          </div>
  
          <div class="folio_just_caption">
            <div>

              <div>
                <a href="#">'.$new_title.'</a>
              </div>
            </div>
          </div>
  
        </div>
      </div>
	';
	
	if (count($attachments) > 0)
	{

      $output .= '
<div class="to_end hidden post_'.$attachments_counter.'">
<div class="big_gallery_bg hidden">
<div class="big_gallery">

  <a href="#" class="go_back">'.__('Back', LANGUAGE_ZONE).'</a>
  <h1>'.$attrs["title"].' <span>1</span></h1>

  <div class="multipics">
      ';
	
	   foreach ($attachments as $att)
	   {
       $orig_image = wp_get_attachment_image_src( $att->ID, 'large' );
       
       $orig_image = default_attachment($orig_image);
       
       $k = $orig_image[1] / $orig_image[2];
       $orig_src = $orig_image[0];
       
       $w = 220;
       
       $h = ceil($w / $k);
       
	   $tmp_src = dt_clean_thumb_url($orig_src);
       $small_image = esc_attr(get_template_directory_uri().'/thumb.php?src='.$tmp_src.'&w='.$w.'&h='.$h.'&zc=1');
       $big_image = $orig_src;
       
/*	      $output .= '
       <a href="'.$big_image.'" class="go_pic size_s" style=" background: url('.$small_image.')" title=""><img height="'.$h.'" src="'.$small_image.'" alt="" /><i></i></a>
	      ';
*/	   	
		$output .= '<a href="'.$big_image.'" data-src="'.$small_image.'" data-width="'.$w.'" data-height="'.$h.'">
			'.wptexturize(trim($att->post_excerpt)).'
		</a>';
		}
		
	   $output .= '
  </div>

  <a href="#" class="go_back">'.__('Back', LANGUAGE_ZONE).'</a>
</div>
</div>
</div>
	   ';
	
	}
   
   return $output;
}

function sakura_lightbox_gallery($attr) {
	global $post, $wp_query;
	$options = array();

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}
	
   if (!isset($attr["album"]) || !$attr["album"])
      return dt_gallery_custom($attr);

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
	
	if ( !isset( $attr['orderby'] ) && get_bloginfo('version')<2.6 ) {
		$attr['orderby'] = 'menu_order ASC, ID ASC';
	}
	
	if ( is_numeric($options['global_settings']['lightbox_gallery_columns']) )  $columns = $options['global_settings']['lightbox_gallery_columns'];
	else $columns = 3;
	
	if ( $options['global_settings']['lightbox_gallery_thumbnailsize'] )  $size = $options['global_settings']['lightbox_gallery_thumbnailsize'];
	else $size = 'thumbnail';

	if ( $options['global_settings']['lightbox_gallery_lightboxsize'] )  $lightboxsize = $options['global_settings']['lightbox_gallery_lightboxsize'];
	else $lightboxsize = 'medium';
		
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => $columns,
		'size'       => $size,
		'include'    => '',
		'exclude'    => '',
		'lightboxsize' => $lightboxsize,
		'meta'       => 'false',
		'class'      => 'gallery1',
		'nofollow'   => false,
		'from'       => '',
		'num'        => '',
		'page'       => $wp_query->query_vars['page'],
		'before' => '<div class="gallery_pagenavi">' . __('Pages:', LANGUAGE_ZONE), 'after' => '</div>',
		'link_before' => '', 'link_after' => '',
		'next_or_number' => 'number', 'nextpagelink' => __('Next page', LANGUAGE_ZONE),
		'previouspagelink' => __('Previous page', LANGUAGE_ZONE), 'pagelink' => '%', 'pagenavi' => 1
	), $attr));
	
	$id = intval($id);

	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';
		
	$total = count($attachments)-$from;
	
	if ( !$page ) $page = 1;
		
	if ( is_numeric($from) && !$num ) :
		$attachments = array_splice($attachments, $from);
	elseif ( is_numeric($page) && is_numeric($num) && $num>0 ) :
		if ( $total%$num == 0 ) $numpages = (int)($total/$num);
		else $numpages = (int)($total/$num)+1;
		$attachments = array_splice($attachments, ($page-1)*$num+$from, $num);
	endif;
	
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link($id, $size, true) . "\n";
		return $output;
	}

	$listtag = tag_escape($listtag);
	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	
	if ( !$options['global_settings']['lightbox_gallery_disable_column_css'] ) :
		$column_css = "<style type='text/css'>
	.gallery-item {width: {$itemwidth}%;}
</style>";
	endif;
	
	$output = apply_filters('gallery_style', $column_css."<div class='gallery {$class}'>");
	
	if ( $class && $options['global_settings']['lightbox_gallery_loading_type'] != 'highslide' ) :
		$output .= '<script type="text/javascript">
// <![CDATA[
	jQuery(document).ready(function () {
         jQuery(".'.$class.' a[rel=lightbox]").attr("rel", "gal\\['.$class.'\\]");
		jQuery(".'.$class.' a[rel=gal\\\\['.$class.'\\\\]]").prettyPhoto();		
         //jQuery(".'.$class.' a[rel=lightbox]").prettyPhoto();
	});
// ]]>
</script>'."\n";


	endif;

   $output.='<ul class="gall_std">';

	foreach ( $attachments as $id => $attachment ) {
	
	//$output .= '<'.$itemtag.' class="gallery-item">'."\n";
	
		if ( $attachment->post_type == 'attachment' ) {
			$thumbnail_link = wp_get_attachment_image_src($attachment->ID, $size, false);
			$lightbox_link = wp_get_attachment_image_src($attachment->ID, $lightboxsize, false);
			trim($attachment->post_content);
			trim($attachment->post_excerpt);
		
			if($meta == "true") {
				$imagedata = wp_get_attachment_metadata($attachment->ID);
				unset($metadata);
				if($imagedata['image_meta']['camera'])
					$metadata .= __('camera', 'lightbox-gallery')            . ": ". $imagedata['image_meta']['camera'] . " ";
				if($imagedata['image_meta']['aperture'])
					$metadata .= __('aperture', 'lightbox-gallery')          . ": F". $imagedata['image_meta']['aperture'] . " ";
				if($imagedata['image_meta']['focal_length'])
					$metadata .= __('focal_length', 'lightbox-gallery')      . ": ". $imagedata['image_meta']['focal_length'] . "mm ";
				if($imagedata['image_meta']['iso'])
					$metadata .= __('ISO', 'lightbox-gallery')      . ": ". $imagedata['image_meta']['iso'] . " ";
				if($imagedata['image_meta']['shutter_speed']) {
					if($imagedata['image_meta']['shutter_speed']<1) $speed = "1/". round(1/$imagedata['image_meta']['shutter_speed']);
					else $speed = $imagedata['image_meta']['shutter_speed'];
					$metadata .= __('shutter_speed', 'lightbox-gallery')     . ": " . $speed . " ";
				}
				if($imagedata['image_meta']['created_timestamp'])
					$metadata .= __('created_timestamp', 'lightbox-gallery') . ": ". date('Y:m:d H:i:s', $imagedata['image_meta']['created_timestamp']);
			}

			$output .= '<li class="shadow_light">
<a class="hs_me" href="'.$lightbox_link[0].'" title="'.$attachment->post_excerpt.'"';
			//if ( $nofollow == "true" ) $output .= ' rel="nofollow"';
			/*
            if ( $options['global_settings']['lightbox_gallery_loading_type'] == 'highslide' ) :
				$output .= ' class="highslide img_bg" onclick="return hs.expand(this,{captionId:'."'caption".$attachment->ID."'".'})"';
			endif;
         */
         //$output .= ' rel="gal['.$class.']"';
			$output .= '><img src="'.$thumbnail_link[0].'" width="'.$thumbnail_link[1].'" height="'.$thumbnail_link[2].'" alt="'.$attachment->post_excerpt.'" /></a>
</li>';
         /*
			if ( $captiontag && (trim($attachment->post_excerpt) || trim($attachment->post_content) || $metadata) && false ) {
				$output .= '<'.$captiontag.' class="gallery-caption" id="caption'.$attachment->ID.'">';
				if($attachment->post_excerpt) $output .= $attachment->post_excerpt . "<br />\n";
				if($attachment->post_content) $output .= $attachment->post_content . "<br />\n";
				if($metadata) $output .= $metadata;
				$output .= '</'.$captiontag.'>';
			}
         */
			//$output .= '</'.$icontag.'>';
	//$output .= '</'.$itemtag.'>';
			$i++;
		}
	}

   $output.='</ul><br style="clear: both;" />';
	
	$output .= '<div style="clear: both;"></div></div>';
	$output .= sakura_wp_link_pages_for_lightbox_gallery(array('before' => $before, 'after' => $after, 'link_before' => $link_before, 'link_after' => $link_after, 'next_or_number' => $next_or_number, 'nextpagelink' => $nextpagelink, 'previouspagelink' => $previouspagelink, 'pagelink' => $pagelink, 'page' => $page, 'numpages' => $numpages, 'pagenavi' => $pagenavi));

	return $output;
}

function sakura_wp_link_pages_for_lightbox_gallery($args = '') {
	global $post;

	$defaults = array(
		'echo' => 0, 'page' => 1, 'numpages' => 1
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );
	
	if ( !$pagenavi ) return;
	
	if ( $numpages > $page ) $more = 1;

	$output = '';
	if ( $numpages > 1 ) {
		if ( 'number' == $next_or_number ) {
			$output .= $before;
			for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
				$j = str_replace('%',"$i",$pagelink);
				$output .= ' ';
				if ( ($i != $page) || ((!$more) && ($page==1)) ) {
					if ( 1 == $i ) {
						$output .= '<a href="' . get_permalink() . '">';
					} else {
						if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
							$output .= '<a href="' . get_permalink() . '&amp;page=' . $i . '">';
						else
							$output .= '<a href="' . trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged') . '">';
					}
				} else {
					$output .= '<span class="current">';
				}
				$output .= $link_before;
				$output .= $j;
				$output .= $link_after;
				if ( ($i != $page) || ((!$more) && ($page==1)) )
					$output .= '</a>';
				else
					$output .= '</span>';
			}
			$output .= $after;
		} else {
			if ( $more ) {
				$output .= $before;
				$i = $page - 1;
				if ( $i && $more ) {
					$output .= '<span id="gallery_prev">';
					if ( 1 == $i ) {
						$output .= '<a href="' . get_permalink() . '">' . $link_before. $previouspagelink . $link_after . '</a>';
					} else {
						if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
							$output .= '<a href="' . get_permalink() . '&amp;page=' . $i . '">' . $link_before. $previouspagelink . $link_after . '</a>';
						else
							$output .= '<a href="' . trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged') . '">' . $link_before. $previouspagelink . $link_after . '</a>';
					}
					$output .= '</span>';
				}
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$output .= '<span id="gallery_next">';
					if ( 1 == $i ) {
						$output .= '<a href="' . get_permalink() . '">' . $link_before. $nextpagelink . $link_after . '</a>';
					} else {
						if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
							$output .= '<a href="' . get_permalink() . '&amp;page=' . $i . '">' . $link_before. $nextpagelink . $link_after . '</a>';
						else
							$output .= '<a href="' . trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged') . '">' . $link_before. $nextpagelink . $link_after . '</a>';
					}
					$output .= '</span>';
				}
				$output .= $after;
			}
		}
	}

	if ( $echo )
		echo $output;

	return $output;
}
?>
