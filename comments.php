<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<div id="comments">
        <fb:comments href="<?php the_permalink(); ?>" num_posts="5" width="420" height="120" reverse="true"></fb:comments>
    </div>
	
	
</div><!-- #comments -->
