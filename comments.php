<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentytwelve_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>
	
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _n( 'Comments {%1$s}', 'Comments {%1$s}', get_comments_number(), 'twentytwelve' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'twentytwelve_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-below" class="navigation" role="navigation">
				<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'twentytwelve' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentytwelve' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentytwelve' ) ); ?></div>
			</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="nocomments"><?php _e( 'Comments are closed.' , 'twentytwelve' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php
	
		// COMMENT REPLY FORM
		
		if ('open' == $post->comment_status) :
			?>
 			<div id="respond">
 			
 				<script language="javascript">
					<!--
					// helper text for form field inputs
					jQuery(document).ready(function() {
						
						// input boxes
						inputbox = jQuery('#respond form#commentform input[type="text"]');
						
						inputbox.focus(function(srcc) {
					    	if (jQuery(this).val() == jQuery(this)[0].title) {
					    		jQuery(this).removeClass("helper-text");
					    		jQuery(this).val("");
					    	}
					    });
					    
					    inputbox.blur(function() {
					        if (jQuery(this).val() == "") {
					        	jQuery(this).addClass("helper-text");
					        	jQuery(this).val(jQuery(this)[0].title);
					        }
					    });
					    
					    inputbox.blur();
					    
					    // textarea
					    textbox = jQuery('#respond form#commentform textarea');
					    
					    textbox.focus(function(srcc) {
					    	if (jQuery(this).val() == jQuery(this)[0].title) {
					    		jQuery(this).removeClass("helper-text");
					    		jQuery(this).val("");
					    	}
					    });
					    
					    textbox.blur(function() {
					        if (jQuery(this).val() == "") {
					        	jQuery(this).addClass("helper-text");
					        	jQuery(this).val(jQuery(this)[0].title);
					        }
					    });
					    
					    textbox.blur();
					
					});
					//-->
				</script>
		 
				<!-- <h3 id="reply-title"><?php comment_form_title( 'Leave a Comment', 'Leave a Reply to %s' ); ?></h3> -->
				 
				<div class="cancel-comment-reply">
				    <small><?php cancel_comment_reply_link(); ?></small>
				</div>
				 
				<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
					<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
				<?php else : ?>
				 
					<?php comment_form(); ?>
								 
				<?php endif; // If registration required and not logged in ?>
			</div>
			<?php
		endif;
	
	?>

</div><!-- #comments .comments-area -->