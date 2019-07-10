<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			<div id="slider-gallery"><?php
				
				/* RESPONSIVE SLIDER GALLERY */
				
				// load our gallery javascripts and css
				wp_enqueue_script( 'jquery-cycle2', get_stylesheet_directory_uri() . '/js/jquery.cycle2.js' );
				wp_enqueue_script( 'jquery-cycle2-center', get_stylesheet_directory_uri() . '/js/jquery.cycle2.center.js' );
				wp_enqueue_script( 'jquery-cycle2-swipe', get_stylesheet_directory_uri() . '/js/jquery.cycle2.swipe.js' );
				//wp_enqueue_script( 'gallery-home', get_stylesheet_directory_uri() . '/js/gallery-home.js', array(), '1.0', true );
				
				$ids_to_exclude = array();
				$post_status_param = wrny_get_post_statuses();
				
				$args = array(
					'category__not_in' => array(6,8), // exclude Bump Envy (6) and Giveaways (8)
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
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<div id="grid-boxes"><?php
			
	/* GRID BOXES */
	
	// LATEST POSTS
	$grid_boxes = new WP_Query( array(
		'category__not_in' => array(6,8),  // exclude Bump Envy (6) and Giveaways (8)
		'post__not_in' => $ids_to_exclude, // exclude posts in above slideshow
		'post_type' => 'post',
		'post_status' => $post_status_param,
		'posts_per_page' => 4,
	) );
	
	$boxes_per_row = 3;
	$c = 0;
	
	if( $grid_boxes->have_posts() ) {
		while( $grid_boxes->have_posts()) : $grid_boxes->the_post();
			
			$c++;
			
			// insert Giveaway in 2nd position
			if( $c == 2 ) {
				
				// LATEST GIVEAWAY
				$giveaway_cat = get_category_by_slug('giveaways'); 
				
				$latest_giveaway_post = new WP_Query( array(
					'posts_per_page' => 1,
					'post_status' => $post_status_param,
					'category__in' => array( $giveaway_cat->term_id ),
				) );
				
				if( $latest_giveaway_post->have_posts() ) : while( $latest_giveaway_post->have_posts() ) : $latest_giveaway_post->the_post();
				
				?>
				<div class="grid-box post-box grid-overlay">
					<div class="post-box-inside">
						<div class="post-box-content">
							<?php wrny_category(); ?>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('medium-callout'); ?></a>
							<div class="excerpt">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><p><?php the_title(); ?></p></a>
								<div class="excerpt-hide"><?php the_excerpt(); ?></div>
							</div>
						</div>
					</div>
				</div>
				<?php
				
				endwhile; endif;
							
				wp_reset_postdata();
			}
			
			// insert Shop in 5th position
			if( $c == 4 ) {
				
				// SHOP PAGE
				$shop_page_post = new WP_Query( array(
					'name' => 'shop',
					'posts_per_page' => 1,
					'post_type' => 'page',
				) );
				
				if( $shop_page_post->have_posts() ) : while( $shop_page_post->have_posts() ) : $shop_page_post->the_post();
				
				?>
				<div class="grid-box post-box grid-overlay">
					<div class="post-box-inside">
						<div class="post-box-content">
							<div class="entry-category"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('medium-callout'); ?></a>
							<div class="excerpt"><?php the_excerpt(); ?></div>
						</div>
					</div>
				</div>
				<?php
				
				endwhile; endif;
							
				wp_reset_postdata();
			}
			
			// default content box
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
	
?></div><!--/#grid-boxes-->

<?php get_footer(); ?>