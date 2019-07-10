<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta property="fb:pages" content="165619990247657" />
<meta name="p:domain_verify" content="b365879402c8ca0f86e5bc9f5d675fc7"/>
<!-- <meta name="viewport" content="width=device-width" /> -->
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<hgroup>
			<div id="nav-items">
				<div id="site-nav" class="toggle-box">
					<a href="Javascript://Menu" class="toggle-nav toggle-button">Menu</a>
				</div>
				<div id="site-nav-box">
					<a href="Javascript://Close" class="close">X</a>
					<div class="section left">
						<div class="section-box">
							<h4>SECTIONS</h4>
							<?php
							
							$nav_items = wp_get_nav_menu_items( 'Section Menu' );
							echo '<ul>';
							foreach( $nav_items as $item ) echo '<li><a href="' . $item->url . '">' . $item->title . '</a></li>';
							echo '</ul>';
							
							?>
						</div>
					</div>
					<div class="section right">
						<div class="section-box">
							<h4>TIPS</h4>
							<?php
							
							$nav_items = wp_get_nav_menu_items( 'Trimester Menu' );
							echo '<ul>';
							foreach( $nav_items as $item ) echo '<li><a href="' . $item->url . '">' . str_replace( 'Trimester' , 'Tri', $item->title ) . '</a></li>';
							echo '</ul>';
							
							?>
						</div>
					</div>
					<div class="section newsletter">
						<div class="section-box">
							<?php wrny_mailchimp_short_form(); ?>
						</div>
					</div>
					<div class="section social">
						<div class="section-box">
							<h4>FOLLOW</h4>
							<?php
							
							// FOLLOW MENU
							$nav_items = wp_get_nav_menu_items( 'Social Menu', $args );
							
							$c = 0;
							
							echo '<div class="social-links">';
							echo '<ul>';
							
							foreach( $nav_items as $item ) {
							
								$c++;
								
								// output link or spacer
								echo '<li><a class="connect-' . strtolower( $item->title ) . '" href="' . $item->url . '">' . $item->title . '</a></li>';
								
							}
							
							echo '</ul>';
							echo '</div><!--/.social-links-->';
							
							?>
						</div>
					</div>
					<div class="section bottom">
						<div class="section-box">
							<?php
							
							// PAGES MENU
							$nav_items = wp_get_nav_menu_items( 'Page Menu' );
							echo '<ul>';
							foreach( $nav_items as $item ) echo '<li><a href="' . $item->url . '">' . $item->title . '</a></li>';
							echo '</ul>';
							
							?>
						</div>
					</div>
					<div class="section copyright">
						<div class="section-box">&copy; 2016 WELL ROUNDED NY. All rights reserved.</div>
					</div>
					<div class="section logo">					
						<div class="section-box">
							<?php $header_image = get_header_image();
							if( !empty( $header_image ) ) : ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" alt="" /></a>
							<?php endif; ?>
						</div>
					</div>
					
				</div>
				<div id="site-search" class="toggle-box">
					<a href="Javascript://Search" class="toggle-search toggle-button">Search</a>
				</div>
				<div id="site-search-box">
					<a href="Javascript://Close" class="close">X</a>
					<div class="section search">
						<?php get_search_form(); ?>
					</div>
				</div>
					
				<h1 class="site-title">
					<?php $header_image = get_header_image();
					if( !empty( $header_image ) ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>
				</h1>
			</div>
			<div class="clear"></div>
		</hgroup>
		<div class="clear"></div>
	</header>
	<?php
			
	// TRIMESTER NAV	
	$nav_items = wp_get_nav_menu_items( 'Trimester Menu' );
	if( !empty( $nav_items ) ) {
		?>
		<div class="nav-boxes">
			<div class="nav-boxes-inside">
				<ul><?php
					$i = 1;
					$num_items = count( $nav_items );
					foreach( $nav_items as $item ) {
						if( $i > 1 ) echo '<li class="spacer"></li>';
						$nice_name = str_replace( 'Trimester' , 'Tri', $item->title );
						echo '<li><a class="nav-' . strtolower( $nice_name ) . '" href="' . $item->url . '">' . $nice_name . '</a></li>';
						$i++;
					}
				?></ul>
			</div>
		</div>
		<?php
	}
	
	?>				
	<div id="main" class="wrapper">