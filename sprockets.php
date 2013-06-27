<?php
/**
 * Plugin Name: Advertisements_two
 * Description: A widget that displays authors name.
 * Version: 0.1
 * Author: Droyal
 * Author URI:
 */

class advertisements_two extends WP_Widget 
{
		function __construct() 
		{
			parent::__construct(false, $name = __( 'Advertisements_two'));
		
		}
		
		function widget($args, $instance)
		{
			?>
			<div id="secondary" class="widget-area one column" role="complementary">
			<?php
				$args = array(
					'post_type' => 'advertisements'
		//			'meta_key' => 'section',
		//			'meta_value' => 'a' 
				);
				$ad_posts = new WP_Query($args);

				if($ad_posts->have_posts()) : 
					while($ad_posts->have_posts()) : 
						$ad_posts->the_post();
						?>

			<?php   //the_post_thumbnail(); 

				if (has_post_thumbnail()) {
					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id()
					);
					echo '<a href="' . $large_image_url[0] . '" title="' .
						the_title_attribute('echo=0') . '" >';
						the_post_thumbnail('large');
					echo '</a>';
				}
				?>

			<?php
				endwhile;
				else: 
					?>

			Oops, there are no posts.

				<?php endif; ?>

			</div><!-- #secondary -->
			<?php
			
		}
		
		function update()
		{
			
		}
		
		function form()
		{
			
		}
}

add_action( 'widgets_init', function() {
	register_widget( 'advertisements_two' );
})
?>