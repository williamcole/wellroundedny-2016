<?php

############
# INCLUDES #
############

require_once( dirname( __FILE__ ) .'/inc/admin.php' );
require_once( dirname( __FILE__ ) .'/inc/ads.php' );
require_once( dirname( __FILE__ ) .'/inc/gallery.php' );
require_once( dirname( __FILE__ ) .'/inc/newsletter.php' );
require_once( dirname( __FILE__ ) .'/inc/picks.php' );
require_once( dirname( __FILE__ ) .'/inc/pinterest.php' );
require_once( dirname( __FILE__ ) .'/inc/shop.php' );
require_once( dirname( __FILE__ ) .'/inc/widgets.php' );

###########
# TESTING #
###########

function wrny_init() {
	if( wrny_is_testing() ) {
		// temporary stylesheet
		//add_filter( 'stylesheet_uri', 'wrny_stylesheet_uri', 10, 2 );
	}
}
//add_action( 'init', 'wrny_init' );

function wrny_is_testing() {
	if( is_wbc3() || is_user_logged_in() ) {
		return true;
	} else {
		return false;
	}
}

// test function for admin Will
function is_wbc3() {
	$bool = false;
	$user = wp_get_current_user();
	if( $user && isset( $user->user_login ) && ( 'williambcole@gmail.com' == $user->user_email ) ) $bool = true;
	return $bool;	
}

// override stylesheet, useful for testing
function wrny_stylesheet_uri( $stylesheet_uri, $stylesheet_dir_uri ) {
    return $stylesheet_dir_uri . '/style.new.css';
}

// show drafts when WP user is logged in
function wrny_get_post_statuses() {
	$array = ( is_user_logged_in() ) ? array('publish','draft') : array('publish');
	return $array;
}


#########
# FONTS #
#########

function wrny_enqueue_styles() { 
	
	// CSS
	wp_register_style( 'bebas-neue', get_stylesheet_directory_uri() . '/fonts/bebas-neue-fontfacekit/stylesheet.css' );
	wp_enqueue_style( 'bebas-neue' );
	wp_register_style( 'gandhi-serif', get_stylesheet_directory_uri() . '/fonts/gandhi-serif-fontfacekit/stylesheet.css' );
	wp_enqueue_style( 'gandhi-serif' );
	wp_register_style( 'roboto', get_stylesheet_directory_uri() . '/fonts/roboto-fontfacekit/stylesheet.css' );
	wp_enqueue_style( 'roboto' );
	wp_register_style( 'neoretro', get_stylesheet_directory_uri() . '/fonts/NeoRetroDraw-fontfacekit/stylesheet.css' );
	wp_enqueue_style( 'neoretro' );
	
	// Newsletter
	wp_register_style( 'newsletter-css', get_stylesheet_directory_uri() . '/css/newsletter.css' );
	wp_enqueue_style( 'newsletter-css' );

	// Editors Picks
	wp_register_style( 'picks-css', get_stylesheet_directory_uri() . '/css/picks.css' );
	wp_enqueue_style( 'picks-css' );
	
	// Shop
	wp_register_style( 'shop-css', get_stylesheet_directory_uri() . '/css/shop.css' );
	wp_enqueue_style( 'shop-css' );

	// JS
	wp_enqueue_script( 'newsletter', get_stylesheet_directory_uri() . '/js/newsletter.js', array(), '1.0', true );
	wp_enqueue_script( 'site', get_stylesheet_directory_uri() . '/js/site.js', array( 'jquery' ), null, true );

}
add_action( 'wp_enqueue_scripts', 'wrny_enqueue_styles' );

function wrny_admin_enqueue_scripts() { 
	
	// Editors Picks
	wp_register_style( 'admin-picks', get_stylesheet_directory_uri() . '/css/admin-picks.css' );
	wp_enqueue_style( 'admin-picks' );

	// Shop
	wp_register_style( 'admin-shop', get_stylesheet_directory_uri() . '/css/admin-shop.css' );
	wp_enqueue_style( 'admin-shop' );
	
}
add_action( 'admin_enqueue_scripts', 'wrny_admin_enqueue_scripts' );


##########
# IMAGES #
##########

// add_image_size( 'name', 300, 100, false );
add_image_size( 'ad', 240, 120, true );
add_image_size( 'horz', 400, 9999, false )	;
add_image_size( 'medium', 300, 200, true );
add_image_size( 'medium-square', 300, 300, true );
add_image_size( 'medium-callout', 300, 322, true );
add_image_size( 'widget', 360, 432, true );
add_image_size( 'archive', 300, 100, true );
add_image_size( 'similar', 150, 100, true );
add_image_size( 'article-gallery', 600, 600, true );
#add_image_size( 'home-gallery', 644, 322, true );
add_image_size( 'author-thumb', 100, 100, true );

// fix http error on image upload
function wrny_change_graphic_lib($array) {
	return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}
add_filter( 'wp_image_editors', 'wrny_change_graphic_lib' );


##########
# HEADER #
##########

# TODO: make favicon image for this

// favicon
function wrny_favicon_link() {
	echo '<link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />' . "\n";
}
// add_action( 'wp_head', 'wrny_favicon_link' );

// write the markup for social media buttons
function wrny_social_media() {
	echo '<div class="social-media">
		<a class="facebook" href="http://facebook.com/wellroundedny" target="_blank">Facebook</a>
		<a class="twitter" href="https://twitter.com/WellRoundedNY" target="_blank">Twitter</a>
		<a class="instagram" href="https://instagram.com/wellroundedny/" target="_blank">Instagram</a>
		<a class="pinterest" href="http://pinterest.com/wellroundedny/" target="_blank">Pinterest</a>
	</div>';
}


##########
# FOOTER #
##########

function wrny_footer_text() {

	$footer_text = get_option( 'wrny_footer_text' );
	
	// display year
	$footer_text = str_replace( '[year]', date( 'Y' ), $footer_text );
	
	if( isset( $footer_text ) ) {
		echo $footer_text;
	}
	
}


###########
# CONTENT #
###########

// mostly needed for widgets
function wrny_custom_excerpt_length( $length ) {
	return 12; // number of words
}
add_filter( 'excerpt_length', 'wrny_custom_excerpt_length', 999 );

// custom category title
function wrny_category( $slug = null ) {
	
	if( !empty( $slug ) ) {
		// override used for home page shop and giveaway grid boxes
		$category = get_category_by_slug( $slug );	
	} else {
		// get existing category
		$category = get_the_category(); 
	}
	
	// TODO: use global function
	$ignore = array( 'Uncategorized', 'Pre', '1st Trimester', '2nd Trimester', '3rd Trimester', 'Post' );
	
	if( $category[0] ) {
		
		echo '<div class="entry-category">';
		
		$c = 0;
		
		foreach( $category as $cat ) {
			
			// ignore Uncategorized
			if( in_array( $cat->cat_name, $ignore ) ) continue;
			
			// output
			if( $c > 0 ) echo ' / ';
			echo '<a href="' . get_category_link( $cat->term_id ) . '">' . $cat->cat_name . '</a>';
			$c++;
			
		}
		
		echo '</div><!--/.entry-category-->';
	}
}

function wrny_get_trimester_categories() {
	return array(
		'pre',
		'1st-trimester',
		'2nd-trimester',
		'3rd-trimester',
		'post'
	);
}

function wrny_get_special_categories() {
	return array(
		'bump-envy',
		'giveaways',
	);
}

// insert the post thumbnail at the top of the content so Pinterest hover tag appears
function wrny_the_post_thumbnail( $content ) {
	
	global $post;

	if( in_category('picks', $post ) ) {
		return $content;
	}

	if( is_single() && has_post_thumbnail() && !get_post_meta( get_the_ID(), 'hide_top_featured_image', true ) ) {
	
		// check if this is a Bump Envy post
		$is_bump_envy = false;
		$categories = get_the_category();
		foreach( $categories as $category ) {
			if( $category->cat_name == 'Bump Envy' ) $is_bump_envy = true;
		}
		
		$img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
		
		if( get_post_meta( get_the_ID(), 'display_vertical_image', true ) || $is_bump_envy ) {
		
			// right floated vertical image
			$content = '<img class="entry-vertical-image" src="' . $img_url . '">' . $content;
			
		} else {
		
			// full width image
			$content = '<div class="featured-image"><img src="' . $img_url . '"></div>' . $content;

		}
		
	}
	
	return $content;

}
add_filter( 'the_content', 'wrny_the_post_thumbnail' );


###########
# GALLERY #
###########

// override gallery shortcode so we can customize it
function wrny_gallery_shortcode( $attr ) {
	
	global $post;
	
	// TODO: run default gallery shortcode on Shop page
	if( $post->post_title == 'Shop' ) {
		return wp_gallery_shortcode( $attr );
	}
	
	// get featured img id to exclude
	$featuredID = get_post_thumbnail_id();
	static $instance = 0;
	$instance++;
	
	if( !empty($attr['ids'] ) ) {
		if( empty( $attr['orderby'] ) ) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}
	
	$output = apply_filters( 'post_gallery', '', $attr );
	
	if( $output != '' ) {
		return $output;
	}
	
	if( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if( !$attr['orderby'] ) {
			unset( $attr['orderby'] );
		}
	}
	
	extract( shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => '',
		'icontag'    => '',
		'captiontag' => '',
		'columns'    => 3,
		'size'       => 'article-gallery',
		'include'    => '',
		'exclude'    => ''
	), $attr ) );
	
	$id = intval( $id );
	
	if( $order === 'RAND' ) {
		$orderby = 'none';
	}
	
	// get the attachments
	if( !empty( $include ) ) {
		
		$_attachments = get_posts( array(
			'include' => $include,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $order,
			'orderby' => $orderby
		) );
		
		$attachments = array();
		
		foreach( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
		
	} elseif( !empty( $exclude ) ) {
		
		$attachments = get_children( array(
			'post_parent' => $id,
			'exclude' => $exclude,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $order,
			'orderby' => $orderby
		) );
		
	} else {
		
		$attachments = get_children( array( 
			'post_parent' => $id,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $order,
			'orderby' => $orderby
		) );
		
	}
	
	if( empty( $attachments ) ) {
		$attachments = get_posts( $args );
	}
	
	// html markup for gallery
	if( $attachments ) {
	
		// RESPONSIVE GALLERY
			
		// load our gallery javascripts and css
		//wp_enqueue_script( 'jquery-scrollpane', get_stylesheet_directory_uri() . '/js/jquery.scrollpane.js', array(), '1.0', true );
		wp_enqueue_script( 'jquery-mousewheel', get_stylesheet_directory_uri() . '/js/jquery.mousewheel.js', array(), '1.0', true );
		//wp_enqueue_style( 'jquery-scrollpane-css', get_stylesheet_directory_uri() . '/css/jquery.scrollpane.css' );
		wp_enqueue_script( 'jquery-cycle2', get_stylesheet_directory_uri() . '/js/jquery.cycle2.js' );
		wp_enqueue_script( 'jquery-cycle2-center', get_stylesheet_directory_uri() . '/js/jquery.cycle2.center.js' );
		wp_enqueue_script( 'jquery-cycle2-swipe', get_stylesheet_directory_uri() . '/js/jquery.cycle2.swipe.js' );
		//wp_enqueue_script( 'gallery', get_stylesheet_directory_uri() . '/js/gallery.js', array(), '1.0', true );
		
		$output .= '<div id="article-gallery">';
		$output .= '<div class="cycle-slideshow" 
			data-cycle-fx="fade" 
			data-cycle-pager=".cycle-pager" 
			data-cycle-slides="> div" 
			data-cycle-swipe=true
			data-cycle-timeout="5000"
			data-cycle-prev="#cycle-prev"
			data-cycle-next="#cycle-next" 
			>';
		
		foreach( $attachments as $attachment ) {
			
			// get image data
		   	$image_array = image_downsize( $attachment->ID, 'article-gallery' );
		   	$image = $image_array[0];
			$image_width = $image_array[1];
			$image_height = $image_array[2];
			
			// markup for each gallery item
			$output .= '    	
		    	<div class="new-gallery-item">
		    		<div class="new-gallery-image">
		    			<div class="cycle-image"><img src="' . $image . '" img-height="' . $image_height .'"></div>
		    			<div id="cycle-prev"></div><div id="cycle-next"></div>
						<div class="cycle-pager"></div>
	    			</div>
		    		<div class="new-gallery-text">
		    			<div class="new-gallery-title">' . $attachment->post_excerpt . '</div>
		    			<div class="new-gallery-content">' . $attachment->post_content . '</div>
		    		</div>
		    		<div class="clear"></div>
		    	</div><!--/.new-gallery-item-->
		    ';
		}
		
	    $output .= '</div><!--/.cycle-slideshow-->';
	    $output .= '</div><!--/#article-gallery-->';
		
	}
	
	return $output;
}
add_shortcode( 'gallery', 'wrny_gallery_shortcode' );

// prev next navigation links
function wrny_prev_next_nav() {
	?>
	<nav class="nav-single">
		<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
		
		<?php
		
		$prev_post = get_previous_post();
		if( !empty( $prev_post ) ) {
			?>
			<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span>%title<span class="excerpt">'.$prev_post->post_excerpt.'</span>' ); ?></span>
			<?php
		}
		
		$next_post = get_next_post();
		if( !empty( $next_post ) ) {
			?>
			<span class="nav-next"><?php next_post_link( '%link', '%title<span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span><span class="excerpt">'.$next_post->post_excerpt.'</span>' ); ?></span>
			<?php
		}
		
		?>
	</nav><!-- .nav-single -->
	<?php
}

// similar stories
// TODO ; get rid of?
function wrny_similar_stories() {
	
	// dont show on press
	if( get_post_type() == 'press' )
		return;

	if( !get_post_meta( get_the_ID(), 'hide_similar_stories', true ) ) {

		// get prev and next post ids to exclude
		$prev_post = get_previous_post();
		$next_post = get_next_post();
		
		$orig_post = $post;
		global $post;
		
		$categories = get_the_category( $post->ID );
		
		if( $categories ) {
			
			// get categories
			$category_ids = array();				
			foreach( $categories as $individual_category ) {
				$category_ids[] = $individual_category->term_id;
			}
			
			$args = array(
				'orderby' => 'rand',
				'category__in' => $category_ids,
				'post__not_in' => array( $post->ID, $prev_post->ID, $next_post->ID ),
				'posts_per_page' => 3,
			);
			
			$similar_posts = new WP_Query( $args );
			
			if( $similar_posts->have_posts() ) {
			
				echo '<div id="similar-stories">';
				echo '	<h3>Similar Stories</h3>';
				echo '		<ul>';

				while( $similar_posts->have_posts() ) {
					
					$similar_posts->the_post();
					
					// get image
					$image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $similar_posts->ID ), 'medium' );
					$image = $image_array[0];
					
					?>
					<li>
						<div class="similar-image"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><img src="<?php echo $image; ?>"></a></div>
						<div class="similar-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
					</li>
					<?php
				}
				
				echo '		</ul>';
				echo '	</div>';
			}
		}
		
		// reset post
		$post = $orig_post;
		wp_reset_query();
	}
}

// display the author info
function wrny_author_info() {
	
	if( !get_post_meta( get_the_ID(), 'hide_author_info', true ) ) {
	
		echo '<div class="entry-author">';
		
		if( function_exists( 'coauthors' ) ) {
			$coauthors = get_coauthors();
			
			//if( is_wbc3() ) print_r($coauthors);
			
			foreach( $coauthors as $coauthor ) {
			
				// set some vars
				$name = $coauthor->display_name;
				$bio = $coauthor->description;
				$url = get_home_url() . '/author/' . $coauthor->user_nicename;
				
				// not needed anymore ???
				if( $coauthor->type == 'guest-author' ) {
					// guest author
					$author_id = $coauthor->ID;
				} else {
					// wp user
					$author_id = get_the_author_meta( 'ID', $coauthor->ID );
				}
				
				// author photo
				echo '<a href="' . $url . '">' . userphoto_thumbnail( $coauthor ) . '</a>';
				#userphoto_the_author_photo(); // not working somtimes?
				#userphoto_the_author_thumbnail(); // grainy
				
				echo '<h4>BY <a href="' . $url . '">' . $name . '</a></h4>';
				
				// expand author info
				// echo '<p class="author-bio">' . $bio . '</p>';
				
				echo '<div class="clear"></div>';
				
			}
		}
		
		echo '</div><!--/.entry-author-->';
	}
}

// category link
function wrny_category_link() {
	
	$category = get_the_category(); 
	
	if( $category[0] ) {
		
		echo '<div class="category-link">';
		echo '<div class="entry-category">';
		echo '<p>Click Here For More</p>';
		
		$c = 0;
		
		foreach( $category as $cat ) {
			
			// ignore Uncategorized
			if( $cat->cat_name == 'Uncategorized' ) continue;
			
			// output
			if( $c > 0 ) echo ' / ';
			echo '<a href="' . get_category_link( $cat->term_id ) . '">' . $cat->cat_name . '</a>';
			$c++;
			
		}
		
		echo '</div></div>';	
	}		
}

###########
# ARCHIVE #
###########

function wrny_the_excerpt( $excerpt ) {
	
	// display title text instead on special catgory archive pages
	if( is_category('giveaways') || is_category('bump-envy') ) {
		$excerpt = '<p>' . get_the_title() . '</p>';
	}
	
	// wrap excerpt in a permalink
	if( !is_single() ) {
		$excerpt = '<a href="' . get_permalink() . '">' . $excerpt . '</a>';
	}
	
	return $excerpt;
}
add_filter( 'the_excerpt', 'wrny_the_excerpt' );


############
# COMMENTS #
############

// override twentytwelve function
function twentytwelve_comment( $comment, $args, $depth ) {
	
	$GLOBALS['comment'] = $comment;
	
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
			<?php
				break;
			default :
			// Proceed with normal comments.
			global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				
				<section class="comment-content comment">
					<?php comment_text(); ?>
					<?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
				</section><!-- .comment-content -->
				
				<header class="comment-meta comment-author vcard">
					<?php
						printf( '<time datetime="%1$s">%2$s</time>',
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s', 'twentytwelve' ), get_comment_date( 'F j, Y' ) )
						);
						printf( '<cite class="fn">%1$s %2$s</cite>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
						);
						
					?>
				</header><!-- .comment-meta -->
	
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
				<?php endif; ?>
				
			</article><!-- #comment-## -->
			<?php
		break;
	endswitch; // end comment_type check
}

// remove the url field from comments
function wrny_remove_website_field( $fields ) {
	if( isset( $fields['url'] ) )
	unset( $fields['url'] );
	return $fields;
}
#add_filter( 'comment_form_default_fields', 'wrny_remove_website_field' );

// get commenter name and email address
function wrny_get_commenter_info( $comment ) {
	
	if( !isset( $comment ) )
		return;
	
	$name = $comment->comment_author;
	$email = $comment->comment_author_email;
	$commenter = $name . ' &mdash; ' . $email;
	
	return $commenter;
}
