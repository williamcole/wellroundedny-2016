<?php
/**
 * Template Name: About Us Page
 */

get_header(); ?>

	<div id="primary" class="site-content full-width">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php
					if( has_post_thumbnail() ) {
						$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
						echo '<div class="about-image-wide"><img src="' . $image_src[0]  . '" width="100%"  /></div>';
					}						
				?>
				<div class="col col-25 left">
					<?php
						if( has_post_thumbnail() ) {
							$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
							echo '<div class="about-image-left"><img src="' . $image_src[0]  . '" width="100%"  /></div>';
						}						
					?>
					<?php echo get_post_meta( get_the_ID(), 'about_us_left_column', true ); ?>
				</div>
				<div class="col col-50 middle">
					<?php get_template_part( 'content', 'page' ); ?>
				</div>
				<div class="col col-25 right">
					<?php echo get_post_meta( get_the_ID(), 'about_us_right_column', true ); ?>
				</div>
				
			<?php endwhile; // end of the loop. ?>
			
			<div class="clear"></div>
			
			<hr>
			
			<?php
				
				/* LIST CONTRIBUTORS (all authors with published posts) */
				
				$args = array(
					'orderby' => 'display_name',
					//'role' => 'contributor',
				);
				
				$guest_authors = get_users( $args );
				
				if( count( $guest_authors ) ) {
					
					echo '<div id="contributors">';
					echo '<h1 class="page-title">Contributors</h1>';
					
					$c = 0;
					
					foreach( $guest_authors as $guest_author ) {
						
						// set author ID
						$guest_author_id = $guest_author->ID;
						
						// only show authors with published posts or galleries
						if( count_user_posts( $guest_author_id ) > 0 ) {
						
							// AUTHOR DATE CHECK
							
							// get most recent author post and check if published within the last year
							$guest_author_args = array(
								'author'        =>  $guest_author_id,
								'orderby'       =>  'post_date',
								'order'         =>  'DESC',
								'posts_per_page' => 1
							);
							
							$guest_author_posts = get_posts( $guest_author_args );
							$check_post_date = $guest_author_posts[0]->post_date;
							
							if( strtotime( $check_post_date ) < strtotime('-1 year') ) {
								continue;
							}
							
							// END AUTHOR DATE CHECK

							$c++;
						
							echo '<div class="col">';							
							
							// author image
							echo '<div class="contributor-photo">';
							echo '<a href="' . get_author_posts_url( $guest_author_id ) . '" class="contributor-link">';
							userphoto( $guest_author_id );
							echo '</a>';
							echo '</div>';
							
							// author name
							echo '<div class="entry-author"><h4><a href="' . get_author_posts_url( $guest_author_id ) . '" class="contributor-link">' . $guest_author->display_name . '</a></h4></div>';
							
							echo '</div>';
							
							/*
							if( $c % 5 == 0) {
								//echo '<div class="clear"></div>';
							}
							*/
						
						}
					
					}
					
					echo '</div>';
				}
			
			?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>