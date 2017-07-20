<?php
/**
 * Created by PhpStorm.
 * User: Programator
 * Date: 18.07.2017
 * Time: 16:20
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */

//Get only the approved comments
function add_comment() {
//	$fields =  array(
//		'author' => '<p class="comment-form-author">' . ( $req ? '<span class="required">*</span>' : '' ) .
//		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
//		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
//		            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
//		'url'    => '<p class="comment-form-url">' .
//		            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
//	)
    ;$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(
		'author' => '<p class="comment-form-author" style="float: left; padding-right: 25px;">'  .
		            '<input id="author" name="author" type="text" value="Jméno' . esc_attr( $commenter['comment_author'] ) . '" size="35"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email" style="float: left; padding-right: 25px;">
		            <input id="email" name="email" type="text" value="email ' . esc_attr(  $commenter['comment_author_email'] ) . '" size="35"' . $aria_req . ' /></p>',
		'web_field'    => '<p class="comment-form-web">' .
		            '<input id="url" name="url" type="text" value="Web" size="35" /></p>',

	);


	$comments_args = array(
		'fields' =>  $fields
	);

	comment_form($comments_args);
}

?>

<div id="comments" class="col-md-8 no-padding-left">
	<?php // You can start editing here -- including this comment! ?>
	<?php if ( have_comments() ) : ?>
    <div class="comments-title">
                 <p>Komentáře</p>
             </div>

        <ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'fws_comment', 'style' => 'ol' ) ); ?>
        </ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <nav id="comment-nav-below" class="navigation" role="navigation">
                <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'fws' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'fws' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'fws' ) ); ?></div>
            </nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
            <p class="nocomments"><?php _e( 'Comments are closed.' , 'fws' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php add_comment(); ?>




