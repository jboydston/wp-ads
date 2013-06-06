<?php
// Change the columns for the edit advertisements screen
function change_columns( $cols ) {
  $cols = array(
    'cb'       => '<input type="checkbox" />',
    'title'      => __( 'Title', 'trans' ),
    'wpads-artist'      => __( 'Graphic Artist', 'trans' ),
    'wpads-bizname' => __( 'Business Name', 'trans' ),
    'wpads-width'	=> __( 'Width', 'trans'),
	'wpads-height'     => __( 'Height', 'trans' ),
	'date'      => __( 'Date', 'trans' ),
  );
  return $cols;
}
add_filter( "manage_advertisements_posts_columns", "change_columns" );

function custom_columns( $column, $post_id ) {
  switch ( $column ) {
    case "wpads-artist":
      $url = get_post_meta( $post_id, 'wpads-artist', true);
      echo '<a href="' . $url . '">' . $url. '</a>';
      break;
    case "wpads-bizname":
      $refer = get_post_meta( $post_id, 'wpads-bizname', true);
      echo '<a href="' . $refer . '">' . $refer. '</a>';
      break;
    case "wpads-width":
      echo get_post_meta( $post_id, 'wpads-width', true);
      break;
    case "wpads-height":
      echo get_post_meta( $post_id, 'wpads-height', true);
      break;
  }
}

add_action( "manage_posts_custom_column", "custom_columns", 10, 2 );

// Make these columns sortable
function sortable_columns() {
  return array(
    'wpads-artist'      => 'wpads-artist',
    'wpads-bizname' => 'wpads-bizname',
    'wpads-width'     => 'wpads-width',
    'wpads-height'     => 'wpads-height'
  );
}

add_filter( "manage_edit-advertisements_sortable_columns", "sortable_columns" );

// Filter the request to just give posts for the given taxonomy, if applicable.
function taxonomy_filter_restrict_manage_posts() {
    global $typenow;

    // If you only want this to work for your specific post type,
    // check for that $type here and then return.
    // This function, if unmodified, will add the dropdown for each
    // post type / taxonomy combination.

    $post_types = get_post_types( array( '_builtin' => false ) );

    if ( in_array( $typenow, $post_types ) ) {
    	$filters = get_object_taxonomies( $typenow );

        foreach ( $filters as $tax_slug ) {
            $tax_obj = get_taxonomy( $tax_slug );
            wp_dropdown_categories( array(
                'show_option_all' => __('Show All '.$tax_obj->label ),
                'taxonomy' 	  => $tax_slug,
                'name' 		  => $tax_obj->name,
                'orderby' 	  => 'name',
                'selected' 	  => $_GET[$tax_slug],
                'hierarchical' 	  => $tax_obj->hierarchical,
                'show_count' 	  => false,
                'hide_empty' 	  => true
            ) );
        }
    }
}

add_action( 'restrict_manage_posts', 'taxonomy_filter_restrict_manage_posts' );

function taxonomy_filter_post_type_request( $query ) {
  global $pagenow, $typenow;

  if ( 'edit.php' == $pagenow ) {
    $filters = get_object_taxonomies( $typenow );
    foreach ( $filters as $tax_slug ) {
      $var = &$query->query_vars[$tax_slug];
      if ( isset( $var ) ) {
        $term = get_term_by( 'id', $var, $tax_slug );
        $var = $term->slug;
      }
    }
  }
}

add_filter( 'parse_query', 'taxonomy_filter_post_type_request' );

// Add a Custom Post Type to a feed
//function add_advertisements_to_feed( $qv ) {
//  if ( isset($qv['feed']) && !isset($qv['post_type']) )
//    $qv['post_type'] = array('post', 'advertisements');
//  return $qv;
//}

//add_filter( 'request', 'add_advertisements_to_feed' );
 
?>