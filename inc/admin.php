<?php

#########
# ADMIN #
#########

// register custom menus
function wrny_register_menus() {
	register_nav_menus( array(
		'mobile-menu' => __( 'Mobile Menu' ),
	) );
}
add_action( 'init', 'wrny_register_menus' );

// toggle Giveaway Winner custom field on posts
function wrny_toggle_custom_fields( $post_type, $post ) {
	if( $post_type == 'post' ) {	
		wp_enqueue_script( 'admin-toggle-post-custom-fields', get_stylesheet_directory_uri() . '/js/admin-toggle-post-custom-fields.js', array( 'jquery' ), null, true );
	}    
}
add_action( 'add_meta_boxes', 'wrny_toggle_custom_fields', 10, 2 );

// register admin page for WRNY
function wrny_admin_menu() {
	
	// add top-level admin page
	add_menu_page( 'Well Rounded NY Options', 'Well Rounded NY', 'manage_options', 'wrny-admin', 'wrny_admin_menu_function' );

	// config for submenu pages
	$submenu_pages = array(
		'Newsletter Subscribers',
		'Giveaway Commenters',
		'Post Ranking',
	);
	
	// create submenu pages
	foreach( $submenu_pages as $submenu ) {
		
		// create slug name
		$submenu_slug = strtolower( str_replace( ' ', '-', $submenu ) );
		$function_slug = strtolower( str_replace( ' ', '_', $submenu ) );
		
		// create submenu page
		add_submenu_page( 'wrny-admin', $submenu, $submenu, 'manage_options', 'wrny-admin-' . $submenu_slug, 'wrny_admin_' . $function_slug . '_function' );

	}
}
add_action( 'admin_menu', 'wrny_admin_menu' );

// top level admin page with Footer Text option
function wrny_admin_menu_function() {

	// Check that the user has the required capability 
    if( !current_user_can( 'manage_options' ) ) {
    	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    
    // Variables for the field and option names 
    $opt_name = 'wrny_footer_text';
    $hidden_field_name = 'wrny_footer_text_hidden';
    $data_field_name = 'wrny_footer_text';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
    
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );

        // Put an settings updated message on the screen
		?>
		<div class="updated">
			<p><strong><?php _e( 'Settings Saved.', 'wrny-footer-text' ); ?></strong></p>
		</div>
		<?php
	}
	
	// Now display the settings editing screen
	?>
	
	<div class="wrap">
		
		<h2>Well Rounded NY Options</h2>
		
		<h3>Footer Copyright Text</h3>
		<form name="form1" method="post" action="">
			<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">			
			<p><textarea type="text" name="<?php echo $data_field_name; ?>" cols="100" rows="5"><?php echo $opt_val; ?></textarea></p>			
			<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes' ) ?>" /></p>
		</form>
	
	</div>
	
	<?php
	
}

// display list of all newsletter subscriber email addresses
function wrny_admin_newsletter_subscribers_function() {
    
    // Check that the user has the required capability 
    if( !current_user_can( 'manage_options' ) ) {
    	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    
    echo '<div class="wrap">';
    	
	// init array for emails
	$email_addresses = array();
	
	// get newsletter email addresses		
	$feedback = new WP_Query( array(
		'post_type' => 'feedback',
		'posts_per_page' => -1
	) );
	
	// loop through feedback
	if( $feedback->have_posts() ) {
		
		$feedback_array = $feedback->posts;
		foreach( $feedback_array as $feedback ) {
			
			$feedback_content = $feedback->post_content;
			$feedback_parts = explode( 'AUTHOR EMAIL: ', $feedback_content );
			$feedback_email = explode( 'AUTHOR URL:', $feedback_parts[1] );
			$email = strtolower( trim( $feedback_email[0] ) );
			
			// check if email exists, if not then add to array
			if( !in_array( strtolower( $email ), $email_addresses ) ) {
				$email_addresses[] = $email;
			}
		}
		
	}
	
	// output
	if( count( $email_addresses ) ) {
		
		// case-insensitive alphabetical sort
		natcasesort( $email_addresses );
		
		// content
		echo '<h2>Newsletter Subscribers [' . count( $email_addresses ) . ']</h2>';
		echo '<p>' . implode( '<br>', $email_addresses ) . '</p>';
	}
		
	wp_reset_query();
		
	echo '</div>';
	
}

// display list of all commenters' email addresses for Giveaways
function wrny_admin_giveaway_commenters_function() {
    
    wp_register_style( 'admin-giveaway-commenters', get_stylesheet_directory_uri() . '/css/admin-giveaway-commenters.css' );
	wp_enqueue_style( 'admin-giveaway-commenters' );
	
    // Check that the user has the required capability 
    if( !current_user_can( 'manage_options' ) ) {
    	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    
    // get query vars
    $id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : false;
    $winner = ( isset( $_GET['winner'] ) ) ? $_GET['winner'] : false;
    
    // if winner is selected
	if( $id && $winner ) {
		
		// get the winning comment
		$winning_comment = get_comment( $winner, OBJECT );
		$winning_commenter = wrny_get_commenter_info( $winning_comment );
		
		// save winning commenter info to post
		update_post_meta( $id, 'giveaway_winner', $winning_commenter );
	
	}
    
    echo '<div class="wrap">';
	
	$giveaways = new WP_Query( array(
		'category_name' => 'giveaways',
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => -1,
	) );
	
	if( $giveaways->have_posts() ) :
		
		echo '<h2>Giveaway Commenters</h2>';
		
		// init array for emails
		$giveaway_commenters = array();
		
		$page = admin_url( 'admin.php?page=wrny-admin-giveaway-commenters' );
		
		while( $giveaways->have_posts()) : $giveaways->the_post();
			
			// check if winner has already been selected
			$giveaway_winner = get_post_meta( get_the_ID(), 'giveaway_winner', true );
			
			// determine bg color
			$class = ( empty( $giveaway_winner ) ) ? 'giveaway-winner' : 'giveaway-winner selected';
			
			echo '<div class="giveaway">';
			echo '	<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
			echo '	<p>' . get_the_date() . ' <em>(' . get_comments_number( get_the_ID() ) . ' Comments)</em></p>';
			echo '	<div class="' . $class . '">';
			
			if( !empty( $giveaway_winner ) ) {
			
				echo '<strong>WINNER: </strong>' . $giveaway_winner;
			
			} else {
			
				// get comments from this Giveaways post
				$comments = get_comments( array(
					'status' => 'approve',
					'post_id' => get_the_ID(),
				) );
				
				if( $comments ) {
					
					// pick a random comment
					$ndx = mt_rand( 1, sizeof( $comments ) ) - 1;
					$comment = $comments[$ndx];
					
					// get commenter name and email
					$commenter = wrny_get_commenter_info( $comment );
					
					echo '<strong>RANDOM COMMENT:</strong><br>"';
					echo $comment->comment_content . '"<br>';
					echo '<div>' . $commenter . '</div>';
					echo '<div>';
					echo '	<a class="refresh-comment" href="' . add_query_arg( array( 'id' => get_the_ID() ), $page ) . '">Refresh Comment</a>';
					echo '	<a class="select-winner" href="' . add_query_arg( array( 'id' => get_the_ID(), 'winner' => $comment->comment_ID ), $page ) . '">Select Winner</a>';
					echo '</div>';
					
				} else {
					echo '<em>No Comments Yet</em>';
				}
				
			}
			
			echo '	</div><!--/.giveaway-winner-->';
			echo '</div><!--/.giveaway-->';
			
		endwhile;
		
	endif;
	
	wp_reset_query();
	
	echo '</div><!--/.wrap-->';
	
}

// display list of all posts ranked by page views
function wrny_admin_post_ranking_function() {
    
    // Check that the user has the required capability 
    if( !current_user_can( 'manage_options' ) ) {
    	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    
    echo '<div class="wrap">';
    
    // get total number of published posts
    $count_posts = wp_count_posts();
    $published_posts = $count_posts->publish;
    //echo 'published_posts = ' . $published_posts . '<br>';
    
    // short circuit
    $published_posts = 500;
    
    // define array
    $post_array = array();
    $inc = 100;
	
	
	################################
    
    
    // code
	$post_ranks = new WP_Query( array(
		//'posts_per_page' => -1,
		'posts_per_page' => 200,
		'post_type' => 'post',
		'post_status' => 'publish',
	) );
	
	if( $post_ranks->have_posts() ) :
		
		// begin logic
		while( $post_ranks->have_posts()) : $post_ranks->the_post();
			
			// define some stuff
			$id = get_the_ID();
			
			// use the number of views as the key so we can easily sort later
			$post_array[] = array(
				'title' => get_the_title(),
				'url' => get_the_permalink(),
				'views' => intval( get_page_views($id) ),
			);
			
		endwhile;
		
		// sort by views descending
		$post_array_sorted = val_sort($post_array, 'views');

		// reverse the array so that order is descending
		$post_array_sorted = array_reverse($post_array_sorted, true);
		#print_r( $post_array_sorted );
		
		// output
		echo '<h2>Post Ranking</h2>';
		echo '<p>This page displays all posts in order of page view ranking.<br>';
		echo '<strong>MAY TAKE A MINUTE TO LOAD! Refreshing or loading the page can deplete resources.</strong></p>';
		echo '<h3>CURRENTLY DISPLAYING ' . count($post_array_sorted) . ' POSTS...</h3><hr>';
		
		// loop through and output
		foreach( $post_array_sorted as $ar ) {
			echo '<div style="margin-bottom:10px">';
			echo '[' . $ar['views'] . '] ';
			echo $ar['title'];
			echo ' - ';
			echo '<a href="'.$ar['url'].'">' . $ar['url'] . '</a>';
			echo '</div>';
		}
		
	endif;
	
	wp_reset_query();	
	
	echo '</div><!--/.wrap-->';
	
}

// helper function for above
function val_sort($array, $key) {
	foreach($array as $k=>$v) { $b[] = strtolower($v[$key]); }
	asort($b);
	foreach($b as $k=>$v) {$c[] = $array[$k];}
	return $c;
}