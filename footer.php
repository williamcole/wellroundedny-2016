<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		
		<div id="footer-newsletter">
			<div class="col"><h4>ADVICE. WISDOM. <strong>DAILY.</strong></h4></div>
			<div class="col newsletter">
				<?php wrny_mailchimp_short_form(); ?>
			</div>
			<div class="clear"></div>
		</div>
		
		<?php
		
		// CONNECT MENU
		$nav_items = wp_get_nav_menu_items( 'Social Menu' );
		
		$c = 0;
		$count = count( $nav_items );
		$cols = 4;
		
		echo '<div id="footer-social-links" class="social-links">';
		echo '<h4>connect with us</h4><ul>';
		
		foreach( $nav_items as $item ) {
		
			$c++;
			
			// output link or spacer
			if( $item->title == 'Spacer' ) {
				echo '<li><a class="spacer">&nbsp;</a></li>';
			} else {
				echo '<li><a class="connect-' . strtolower( $item->title ) . '" href="' . $item->url . '" target="_blank">' . $item->title . '</a></li>';
			}
		}
		
		echo '</ul>';
		echo '</div><!--#footer-social-links-->';
		
		// FOOTER MENU NAV
		$nav_items = wp_get_nav_menu_items( 'Footer Menu', $args );
		
		$c = 0;
		$count = count( $nav_items );
		$cols = 4;
		
		echo '<div id="footer-nav">';
		echo '	<div class="footer-col">';
		
		foreach( $nav_items as $item ) {
		
			$c++;
			
			// output link or spacer
			if( $item->title == 'Spacer' ) {
				echo '<a class="spacer">&nbsp;</a>';
			} else {
				echo '<a href="' . $item->url . '">' . $item->title . '</a>';
			}
			
			// column break
			if( ( $c % $cols == 0 ) && ( $c !== $count ) ) {
				echo '</div><!--.footer-col-->';
				echo '<div class="footer-col">';
			}
			
		}
		
		echo '	</div><!--.footer-col-->';
		echo '</div><!--#footer-nav-->';
		
		?>
		<div class="site-info"><?php wrny_footer_text(); ?></div><!-- .site-info -->		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-63959409-1', 'auto');
    ga('send', 'pageview');

</script>

</body>
</html>