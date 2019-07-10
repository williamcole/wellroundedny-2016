<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<div class="featured-post">
				<?php _e( 'Featured post', 'twentytwelve' ); ?>
			</div>
		<?php endif; ?>
	
		<header class="entry-header">

				<?php wrny_category(); ?>
				
				<div class="entry-date">
					<?php the_date( 'm.d.y' ); ?>
				</div><!--/.entry-date -->
				
				<h1 class="entry-title">
					<?php if( is_single() ) : ?>				
						<?php the_title(); ?>
					<?php else : ?>
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					<?php endif; ?>
				</h1><!--/.entry-title -->
				
				<?php wrny_author_info(); ?>
				
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
				
		</header><!-- .entry-header -->
		
		<div class="entry-content"><?php
			
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) );
			wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) );
		
		?></div><!-- .entry-content -->
		
		<footer class="entry-meta"><?php
			
			# NOTE #
			# this stuff is hidden, but might be good for SEO, so leaving it intact 
			
			twentytwelve_entry_meta(); 
			edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' );
			
			// if a user has filled out their description and this is a multi-author blog, show a bio on their entries
			if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) :
				?>
				<div class="author-info">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentytwelve_author_bio_avatar_size', 68 ) ); ?>
					</div><!-- .author-avatar -->
					<div class="author-description">
                        <h2><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentytwelve' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
				<?php
			
			endif;
		
		?></footer><!-- .entry-meta -->
	</article><!-- #post -->