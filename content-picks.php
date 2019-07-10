<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

?>
<!-- CONTENT -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'twentytwelve' ); ?>
		</div>
	<?php endif; ?>
	<header class="entry-header">

		<?php if( is_archive() ) { ?>

			<div class="archive-box">
				
				<?php if ( is_single() ) : ?>				
					<h1 class="entry-title">
						<?php the_title(); ?>
					</h1><!--/.entry-title -->
				<?php else : ?>
					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h1><!--/.entry-title -->
				<?php endif; // is_single() ?>
				
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			</div>

		<?php } else { ?>

			<div class="entry-date picks">
				<?php the_date( 'm.d.y' ); ?>
			</div><!--/.entry-date -->
			
			<?php if ( is_single() ) : ?>				
				<h1 class="entry-title picks">
					<?php the_title(); ?>
				</h1><!--/.entry-title -->
			<?php else : ?>
				<h1 class="entry-title picks">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h1><!--/.entry-title -->
			<?php endif; // is_single() ?>
			
			<div class="entry-summary picks">
				<?php wrny_picks_header(); ?>
			</div><!-- .entry-summary -->

		<?php } ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	
	<?php elseif ( !is_category() ) : ?>
		
		<div class="entry-content picks">
			<?php wrny_picks_content(); ?>
		</div><!-- .entry-content -->
		
	<?php endif; ?>

</article><!-- #post -->
