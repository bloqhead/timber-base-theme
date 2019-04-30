<?php

/**
 * Functions that are meant to be called inside of Twig templates or the Loop
 * 
 * @package  WordPress
 * @subpackage  Kelp
*/

/**
 *	Returns HTML friendly phone number for 'tel:'
 */
if ( ! function_exists( 'kelp_htmlifyPhone' ) ) :
function kelp_htmlifyPhone ($number = '') {
  return 'tel:' . preg_replace("/[^0-9,]/", "", $number);
}
endif;

/**
 * Expects an array, and checks to make sure a key exists before returning. Good for twig.
 */
if ( ! function_exists( 'kelp_getTableVar' ) ) :
function kelp_getTableVar(array $table, $field, $default = '')
{
  if (isset($table[$field])) {
    return $table[$field];
  }

  return $default;
}
endif;

if ( ! function_exists( 'kelp_headerMeta' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function kelp_headerMeta($post) {
  // If $post not sent, we are assuming it is in the loop
  $publish_date = new DateTime($post->post_date);
  $modified_date = new DateTime($post->post_modified);
  $permalink = $post->link;
  $author_link = get_author_posts_url($post->post_author);
  $author_name = get_the_author_meta('display_name', $post->post_author);

  $posted_on = '';
  if (apply_filters('kelp_meta_includeDate', true)) {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    $time_string = sprintf( $time_string,
      esc_attr($publish_date->format('c')),
      esc_html($publish_date->format('F j, Y')),
      esc_attr($modified_date->format('c')),
      esc_html($modified_date->format('F j, Y'))
    );

    $posted_on = sprintf(
      esc_html_x( 'Posted on %s', 'post date', 'kelp' ),
      '<span class="posted-on"><a href="' . esc_url( $permalink ) . '" rel="bookmark">' . $time_string . '</a></span>'
    );
  }

  $byline = '';
  if (apply_filters('kelp_meta_includeAuthor', true)) {
    $byline = sprintf(
      esc_html_x( 'by %s', 'post author', 'kelp' ),
      '<span class="byline"><span class="author vcard"><a class="url fn n" href="' . esc_url( $author_link ) . '">' . esc_html( $author_name ) . '</a></span></span>'
    );
  }

  return apply_filters('kelp_header_meta', $posted_on . ' ' . $byline, $posted_on, $byline); // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'kelp_footerMeta' ) ) :

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function kelp_footerMeta() {
  // Hide category and tag text for pages.
  if ( 'post' === get_post_type() ) {
    /* translators: used between list items, there is a space after the comma */
    if (apply_filters('kelp_meta_includeCategories', true)) {
      $categories_list = get_the_category_list( esc_html__( ', ', 'kelp' ) );
      if ( $categories_list && kelp_hasMultipleCategories() ) {
        printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'kelp' ) . '</span>', $categories_list ); // WPCS: XSS OK.
      }
    }

    /* translators: used between list items, there is a space after the comma */
    if (apply_filters('kelp_meta_includeTags', true)) {
      $tags_list = get_the_tag_list( '', esc_html__( ', ', 'kelp' ) );
      if ( $tags_list ) {
        printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'kelp' ) . '</span>', $tags_list ); // WPCS: XSS OK.
      }
    }
  }

  if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
    echo '<span class="comments-link">';
      /* translators: %s: post title */
      comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'kelp' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
    echo '</span>';
  }

  edit_post_link(
    sprintf(
      /* translators: %s: Name of current post */
      esc_html__( 'Edit %s', 'kelp' ),
      the_title( '<span class="screen-reader-text">"', '"</span>', false )
    ),
    '<span class="edit-link">',
    '</span>'
  );
}
endif;

