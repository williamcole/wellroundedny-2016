<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
			<div id="slider-gallery"><?php
				
				/* RESPONSIVE HOME GALLERY */
				
				// load our gallery javascripts and css
				wp_enqueue_script( 'jquery-cycle2', get_stylesheet_directory_uri() . '/js/jquery.cycle2.js' );
				wp_enqueue_script( 'jquery-cycle2-center', get_stylesheet_directory_uri() . '/js/jquery.cycle2.center.js' );
				wp_enqueue_script( 'jquery-cycle2-swipe', get_stylesheet_directory_uri() . '/js/jquery.cycle2.swipe.js' );
				//wp_enqueue_script( 'gallery-home', get_stylesheet_directory_uri() . '/js/gallery-home.js', array(), '1.0', true );
				
				$ids_to_exclude = array();
				$post_status_param = wrny_get_post_statuses();
				
				$args = array(
					'category__in' => $cat, // this category 
					'post_type' => 'post',
					'post_status' => $post_status_param,
					'posts_per_page' => 3,
				);
				
				$slider_gallery = new WP_Query( $args );
				
				if( $slider_gallery->have_posts() ) :
					echo '<div id="cycle-prev"></div><div id="cycle-next"></div>';
					echo '<div class="cycle-slideshow" 
						data-cycle-fx="fade" 
						data-cycle-pager=".cycle-pager" 
						data-cycle-slides="> div" 
						data-cycle-swipe=true
						data-cycle-timeout="5000"
						data-cycle-prev="#cycle-prev"
						data-cycle-next="#cycle-next" 
						>';
					
					while( $slider_gallery->have_posts()) : $slider_gallery->the_post();
						
						// save these ids so we can exclude below
						$ids_to_exclude[] = $post->ID;
						
						?>
						
						<div class="new-gallery-item">
							<div class="cycle-image"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('medium-square'); ?></a></div>
				    		<div class="gallery-content">
				    			<?php wrny_category(); ?>
					    		<div class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></div>
					    		<div class="entry-summary"><?php the_excerpt(); ?></div>
				    		</div>
				    	</div>
				    	
						<?php
						
					endwhile;
				
					echo '</div><!--/.cycle-slideshow-->';
					echo '<div class="clear"></div>';
				
				endif;
				
				wp_reset_query();
								
			?></div><!-- #slider-gallery -->
		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>

<?php if ( have_posts() ) : ?>

	<div id="grid-boxes">
		<?php
		
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			
		/* GRID BOXES */
		
		// CATEGORY ARCHIVE POSTS
		$args = array(
			'category__in' => $cat, // this archive category
			'post__not_in' => $ids_to_exclude, // exclude posts in above slideshow
			'post_type' => 'post',
			'post_status' => $post_status_param,
			'posts_per_page' => 12,
			'paged' => $paged
		);
		
		$grid_boxes = new WP_Query( $args );
		
		if( $grid_boxes->have_posts() ) {
			while( $grid_boxes->have_posts()) : $grid_boxes->the_post();
				
				?>
				<div class="grid-box post-box">
					<div class="post-box-inside">
						<div class="post-box-content">
							<?php wrny_category(); ?>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('medium-square'); ?></a>
							<div class="excerpt"><?php the_excerpt(); ?></div>
						</div>
					</div>
				</div>
				<?php
				
			endwhile;
		}
		
		wp_reset_query();
		
		twentytwelve_content_nav( 'nav-below' );
		
	?></div><!--/#grid-boxes-->

<?php else : ?>
	<?php get_template_part( 'content', 'none' ); ?>
<?php endif; ?>
			
<?php get_footer(); ?>