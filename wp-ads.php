<?php
   /*
   Plugin Name: WP-Ads
   Plugin URI: http://joeboydston.com/wp-ads
   Description: a plugin to create a custom post type for ads
   Version: 1.0
   Author: Joe Boydston
   Author URI: http://joeboydston.com
   License: GPL2
   */

	// Kick off
	add_action( 'init', 'wpads_register_post_type' );

	function wpads_register_post_type() {
	$labels = array(
		'name'               => _x( 'Advertisements', 'post type general name' ),
		'singular_name'      => _x( 'Advertisement', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'advertisement' ),
		'add_new_item'       => __( 'Add New Advertisement' ),
		'edit_item'          => __( 'Edit Advertisement' ),
		'new_item'           => __( 'New Advertisement' ),
		'all_items'          => __( 'All Advertisements' ),
		'view_item'          => __( 'View Advertisement' ),
		'search_items'       => __( 'Search Advertisements' ),
		'not_found'          => __( 'No Advertisements found' ),
		'not_found_in_trash' => __( 'No Advertisements found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Advertisements',
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Advertisements and ad specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'custom-fields', 'author', 'thumbnail' ),
//		'taxonomies' 	=> array('post_tag', 'category'),
		'has_archive'   => true,
	);
	register_post_type( 'advertisements', $args );	
	}


	/* Run our meta box setup function on the post editor screen. */
	add_action( 'load-post.php', 'wpads_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'wpads_post_meta_boxes_setup' );


	/* Meta box setup function. */
	function wpads_post_meta_boxes_setup() {
		/* Add meta boxes on the 'add_meta_boxes' hook. */
		add_action( 'add_meta_boxes', 'wpads_add_post_meta_boxes' );
	}



	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function wpads_add_post_meta_boxes() {

		add_meta_box(
			'wpads-post-class',			// Unique ID
			esc_html__( 'Ad Details' ),		// Title
			'wpads_post_class_meta_box',		// Callback function
			'advertisements',					// Admin page (or post type)
			'normal',					// Context
			'high'					// Priority
		);		
	} //end wpads_add_post_meta_boxes



	/* Display the post meta box. */
	function wpads_post_class_meta_box( $advertisement ) {

	  // Use nonce for verification
	  wp_nonce_field( plugin_basename( __FILE__ ), 'wpads_noncename' ); ?>

		<p>
			<label for="wpads-post-class"><?php _e( "Sales Rep", 'salesrep-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_the_author() ); ?>" size="30" />
		</p>
		<p>
			<label for="wpads-post-class"><?php _e( "Graphic Artist", 'artist-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-artist" id="wpads-artist-id" value="<?php echo esc_attr( get_post_meta( $advertisement->ID, 'wpads-artist', true ) ); ?>" size="30" />
		</p>
		<p>
			<label for="wpads-post-class"><?php _e( "Business Name", 'bizname-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_post_meta( $advertisement->ID, 'wpads-biz-name', true ) ); ?>" size="30" />
		</p>
		<p>
			<label for="wpads-post-class"><?php _e( "Height", 'height-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_post_meta( $advertisement->ID, 'wpads-height', true ) ); ?>" size="30" />
		</p>
			<label for="wpads-post-class"><?php _e( "Width", 'width-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_post_meta( $advertisement->ID, 'wpads-width', true ) ); ?>" size="30" />
		</p>
			<label for="wpads-post-class"><?php _e( "Page", 'page-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_post_meta( $advertisement->ID, 'wpads-page', true ) ); ?>" size="30" />
		</p>
			<label for="wpads-post-class"><?php _e( "Section", 'section-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_post_meta( $advertisement->ID, 'wpads-section', true ) ); ?>" size="30" />
		</p>
			<label for="wpads-post-class"><?php _e( "URL", 'url-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_post_meta( $advertisement->ID, 'wpads-url', true ) ); ?>" size="30" />
		</p>
			<label for="wpads-post-class"><?php _e( "Phone Number", 'phone-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_post_meta( $advertisement->ID, 'wpads-phone', true ) ); ?>" size="30" />
		</p>
	<?php
	} //end display metabox

	
	add_action( 'save_post', 'wpads_save');
	
	function wpads_save() {
		//if saving in a custom table, get post_ID
		  $post_ID = $_POST['post_ID'];
		  //sanitize user input
		  $mydata = sanitize_text_field( $_POST['wpads-artist'] );

		  // Do something with $mydata 
		  // either using 
		  add_post_meta($post_ID, 'wpads-artist', $mydata, true) or
		    update_post_meta($post_ID, 'wpads-artist', $mydata);
		  // or a custom table (see Further Reading section below)
		}
	
	
?>