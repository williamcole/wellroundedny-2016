<?php
/**
 * Template Name: Mailchimp Newsletter Page
 */

get_header(); ?>
	
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<div id="newsletter-content">
				<?php wrny_mailchimp_form(); ?>
			</div>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>