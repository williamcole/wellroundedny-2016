<?php
/**
 * Template Name: Newsletter Page
 */

get_header(); ?>
	
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<div id="newsletter-content"><?php get_template_part( 'content', 'page' ); ?></div>
			<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>