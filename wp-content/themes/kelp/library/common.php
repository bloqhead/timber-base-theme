<?php

  /**
   * Common Backend Functions. Should never be called inside of Twig.
   * 
   * @package  WordPress
   * @subpackage  Kelp
   */

  define('KELP_CATEGORY_TRANSIENT', 'kelp_categories');

  if (!function_exists('setPageFullWidth')) :
  function setPageFullWidth()
  {
    add_filter( 'big-sea-body_class-has-sidebar', '__return_false');
  }
  endif;

  if (!function_exists('setPageFullWidth')) :
  function allowBeaverBuilder()
  {
    the_post();
  }
  endif;

  /**
   * Returns true if a blog has more than 1 category.
   *
   * @return bool
   */
  if (!function_exists('setPageFullWidth')) :
  function kelp_hasMultipleCategories() {
    if ( false === ($postCategories = get_transient(KELP_CATEGORY_TRANSIENT)) ) {
      // Create an array of all the categories that are attached to posts.
      $postCategories = get_categories( array(
        'fields'     => 'ids',
        'hide_empty' => 1,
        // We only need to know if there is more than one category.
        'number'     => 2,
      ) );

      // Count the number of categories that are attached to the posts.
      $postCategories = count( $postCategories );

      set_transient(KELP_CATEGORY_TRANSIENT, $postCategories);
    }

    if ( $postCategories > 1 ) {
      // This blog has more than 1 category
      return true;
    }
    
    // This blog has only 1 category
    return false;
  }
  endif;