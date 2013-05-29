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
?>
<?php
	add_action( 'init', 'wpads_register_post_type' );

	function wpads_register_post_type() {
	$labels = array(
		'name'               => _x( 'Ads', 'post type general name' ),
		'singular_name'      => _x( 'Ad', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'ad' ),
		'add_new_item'       => __( 'Add New Ad' ),
		'edit_item'          => __( 'Edit Ad' ),
		'new_item'           => __( 'New Ad' ),
		'all_items'          => __( 'All Ads' ),
		'view_item'          => __( 'View Ad' ),
		'search_items'       => __( 'Search Ads' ),
		'not_found'          => __( 'No Ads found' ),
		'not_found_in_trash' => __( 'No Ads found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Ads',
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Ads and ad specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'custom-fields', 'thumbnail' ),
//		'taxonomies' 	=> array('post_tag', 'category'),
		'has_archive'   => true,
	);
	register_post_type( 'ad', $args );	
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
			esc_html__( 'Graphic Artist', 'example' ),		// Title
			'wpads_post_class_meta_box',		// Callback function
			'ad',					// Admin page (or post type)
			'normal',					// Context
			'high'					// Priority
		);
	}



	/* Display the post meta box. */
	function wpads_post_class_meta_box( $object, $box ) {
		wp_nonce_field( basename( __FILE__ ), 'wpads_post_class_nonce' );?>
		<p>
			<label for="wpads-post-class"><?php _e( "Some descriptive text?", 'artist-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_post_meta( $object->ID, 'wpads-artist', true ) ); ?>" size="30" />
		</p>
		<p>
			<label for="wpads-post-class"><?php _e( "Some descriptive text?", 'artist-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_post_meta( $object->ID, 'wpads-biz-name', true ) ); ?>" size="30" />
		</p>
		<p>
			<label for="wpads-post-class"><?php _e( "Some descriptive text?", 'artist-lable' ); ?></label>
			<br />
			<input class="widefat" type="text" name="wpads-post-class" id="wpads-post-class" value="<?php echo esc_attr( get_post_meta( $object->ID, 'wpads-biz-name', true ) ); ?>" size="30" />
		</p>
	<?php
	}
?>