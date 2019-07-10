<?php
/**
 * The template for displaying Author Archive pages.
 *
 * Used to display archive-type pages for posts by an author.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<section id="primary" class="site-content full-width">
		<div id="content" role="main">
		
		<?php if ( have_posts() ) : ?>

			<?php
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
			?>
			
			<!-- HIDDEN / Keep for seo -->
			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( '%s', 'twentytwelve' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
			</header><!-- .archive-header -->

			<?php
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
			?>

			<?php #twentytwelve_content_nav( 'nav-above' ); ?>

			<?php
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) : ?>
				<div class="author-info">
					<div class="author-description">
						<h1 class="page-title"><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h1>
						<?php
							// author image
							if( function_exists( 'userphoto_the_author_photo' ) ) {
								echo '<div class="author-avatar">';
								userphoto_the_author_photo();
								echo '</div><!-- .author-avatar -->';
							}							
						?>
						<div class="author-desc-text"><?php the_author_meta( 'description' ); ?></div>
					</div><!-- .author-description	-->
				</div><!-- .author-info -->
			<?php endif; ?>

			<?php
			
			// change default number of posts to 12
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			query_posts( 'showposts=12&author=' . get_the_author_meta('ID') . '&paged=' . $paged );
			
			/* Start the Loop */
			
			 ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content-archive', get_post_format() ); ?>
			<?php endwhile; ?>
			
			<div class="clear"></div>

			<?php twentytwelve_content_nav( 'nav-below' ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php #get_sidebar(); ?>
<?php get_footer(); ?>