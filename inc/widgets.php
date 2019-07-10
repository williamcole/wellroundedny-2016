<?php

###########
# WIDGETS #
###########

// remove unneeded widgets and add some custom ones
function wrny_widgets_init() {

	// clean up widget stuff
	unregister_sidebar( 'sidebar-2' );
    unregister_sidebar( 'sidebar-3' );
    
	// remove some default Wordpress widgets
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Nav_Menu_Widget');
	
	/*
	
	// home page widget area
	register_sidebar( array(
		'name' => 'Home Page Widgets',
		'id' => 'home-page-widgets',
		'description' => __('Widgets in this area will be shown on the home page.','adapt'),
		'before_widget' => '<div class="sidebar-box clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h4><span>',
		'after_title' => '</span></h4>',
	) );
	
	*/	
	
	register_widget( 'WRNY_Bump_Envy_Widget' );
	register_widget( 'WRNY_Giveaways_Widget' );
	#register_widget( 'WRNY_Trimester_Widget' );
	
	# NEW
	#register_widget( 'WRNY_Registry_Widget' );
	register_widget( 'WRNY_Shop_Widget' );
	
}
add_action( 'widgets_init', 'wrny_widgets_init', 99 );

// Bump Envy
class WRNY_Bump_Envy_Widget extends WP_Widget {  
	
	function WRNY_Bump_Envy_Widget() {  
		parent::WP_Widget( false, 'WRNY: Bump Envy Widget' );
		
		parent::__construct(
			'WRNY_Bump_Envy_Widget',
			'WRNY: Bump Envy Widget',
			array( 'description' => 'Displays the latest Bump Envy article' )
		);
		
	}  
	
	function form( $instance ) {  
		// outputs the options form on admin  
	}  
	
	function update( $new_instance, $old_instance ) {
		// processes widget options to be saved  
		return $new_instance;  
	}  
	
	function widget( $args, $instance ) {  
		
		$category_name = 'bump-envy';
		$category_nice_name = 'Bump Envy';
		
		// outputs the content of the widget		
		$args = array(
			'category_name' => $category_name,
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'post__not_in' => array( get_the_ID() )
		);
		
		$widget_content = new WP_Query( $args );
		
		if( $widget_content->have_posts() ) {
			while( $widget_content->have_posts()) : $widget_content->the_post();
				?>
				<aside class="widget widget_text <?php echo $category_name; ?>">
					<h3 class="entry-category"><a href="<?php echo esc_url( home_url( '/category/' . $category_name ) ); ?>"><?php echo $category_nice_name; ?></a></h3>
					<div class="textwidget">
						<?php if( has_post_thumbnail() ) { ?>
							<div class="widget-image"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_post_thumbnail('widget'); ?></a></div>
						<?php } ?>
						<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
							<span class="prefix">Pregnancy Style with</span>
							<span class="name"><?php the_title(); ?></span>
						</a></h4>
						<div class="clear"></div>
					</div>
				</aside>
				<?php
			endwhile;
		}
		
		wp_reset_query();
	}
}


// Giveaways
class WRNY_Giveaways_Widget extends WP_Widget {  
	
	function WRNY_Giveaways_Widget() {  
		parent::WP_Widget( false, 'WRNY: Giveaways Widget' );
		
		parent::__construct(
			'WRNY_Giveaways_Widget',
			'WRNY: Giveaways Widget',
			array( 'description' => 'Displays the latest Giveaways article' )
		);
		
	}  
	
	function form( $instance ) {  
		// outputs the options form on admin  
	}  
	
	function update( $new_instance, $old_instance ) {
		// processes widget options to be saved  
		return $new_instance;  
	}  
	
	function widget( $args, $instance ) {
		
		// don't show on home page
		if( is_home() || is_archive() )
			return;
		
		$category_name = 'giveaways';
		$category_nice_name = 'Giveaways';
		
		// outputs the content of the widget		
		$args = array(
			'category_name' => $category_name,
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'post__not_in' => array( get_the_ID() )
		);
		
		$widget_content = new WP_Query( $args );
		
		if( $widget_content->have_posts() ) {
			while( $widget_content->have_posts()) : $widget_content->the_post();
				?>
				<aside class="widget widget_text <?php echo $category_name; ?>">
					<h3 class="entry-category"><a href="<?php echo esc_url( home_url( '/category/' . $category_name ) ); ?>"><?php echo $category_nice_name; ?></a></h3>
					<div class="textwidget">
						<?php if( has_post_thumbnail() ) { ?>
							<div class="widget-image"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_post_thumbnail('widget'); ?></a></div>
						<?php } ?>
						<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
							<span class="name"><?php the_title(); ?></span>
						</a></h4>
						<div class="clear"></div>
					</div>
				</aside>
				<?php
			endwhile;
		}
		
		wp_reset_query();
	}
}


// Tips By Trimester
class WRNY_Trimester_Widget extends WP_Widget {  
	
	function WRNY_Trimester_Widget() {  
		parent::WP_Widget( false, 'WRNY: Trimester Widget' );
		
		parent::__construct(
			'WRNY_Trimester_Widget',
			'WRNY: Trimester Widget',
			array( 'description' => 'Displays links to Trimester archives' )
		);
		
	}  
	
	function form( $instance ) {  
		// outputs the options form on admin  
	}  
	
	function update( $new_instance, $old_instance ) {
		// processes widget options to be saved  
		return $new_instance;  
	}  
	
	function widget( $args, $instance ) {  
		
		// don't show on home page
		if( is_home() || is_archive() )
			return;
		
		// outputs the content of the widget		
		?>		
		<aside class="widget widget_text trimester" id="trimester-widget">
			<div class="widget-table">
				<div class="widget-cell left"></div>
				<div class="widget-cell middle">
					<h3 class="widget-title"><a href="<?php echo esc_url( home_url( '/category/1st-trimester/' ) ); ?>">Tips By Trimester</a></h3>
					<div class="textwidget" id="trimester-numbers">
						<a href="<?php echo esc_url( home_url( '/category/1st-trimester/' ) ); ?>">1</a>
						<a href="<?php echo esc_url( home_url( '/category/2nd-trimester/' ) ); ?>">2</a>
						<a href="<?php echo esc_url( home_url( '/category/3rd-trimester/' ) ); ?>">3</a>
					</div>
					<div class="clear"></div>
				</div>
				<div class="widget-cell right"></div>
			</div>
		</aside>		
		<?php	
	}
	  
}


// Shop
class WRNY_Shop_Widget extends WP_Widget {  
	
	function WRNY_Shop_Widget() {  
		parent::WP_Widget( false, 'WRNY: Shop Widget' );
		
		parent::__construct(
			'WRNY_Shop_Widget',
			'WRNY: Shop Widget',
			array( 'description' => 'Displays link to the Shop page' )
		);
		
	}  
	
	function form( $instance ) {  
		// outputs the options form on admin  
	}  
	
	function update( $new_instance, $old_instance ) {
		// processes widget options to be saved  
		return $new_instance;  
	}  
	
	function widget( $args, $instance ) {  
		
		// don't show on home page
		if( is_home() || is_archive() )
			return;
		
		$category_name = 'shop';
		$category_nice_name = 'Shop';
		
		// outputs the content of the widget		
		$args = array(
			'name' => $category_name,
			'post_type' => 'page',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'post__not_in' => array( get_the_ID() )
		);
		
		$widget_content = new WP_Query( $args );
		
		if( $widget_content->have_posts() ) {
			while( $widget_content->have_posts()) : $widget_content->the_post();
				?>
				<aside class="widget widget_text <?php echo $category_name; ?>">
					<div class="textwidget">
						<?php if( has_post_thumbnail() ) { ?>
							<div class="widget-image">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_post_thumbnail('medium-square'); ?></a>
								<div class="entry-category"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
							</div>
						<?php } ?>
						<div class="clear"></div>
					</div>
				</aside>
				<?php
			endwhile;
		}
		
		wp_reset_query();
	}
}
