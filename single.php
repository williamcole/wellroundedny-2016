<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header();

// MOVE THIS ???
wp_enqueue_script( 'pinterest', get_stylesheet_directory_uri() . '/js/pinterest.js', array(), '1.0', true );

?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php

				if( in_category('picks') ) {
					
					// editors picks
					get_template_part( 'content-picks', get_post_format() );
				
				} else {
				
					// standard content
					get_template_part( 'content', get_post_format() );
					
					//wrny_similar_stories();
					wrny_category_link();
					//wrny_prev_next_nav();
					comments_template( '', true );
				
				}
	
				?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>