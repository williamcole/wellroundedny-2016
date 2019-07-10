<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
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
