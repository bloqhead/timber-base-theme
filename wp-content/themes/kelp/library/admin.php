<?php

  /**
   * Admin only Hooks
   * 
   * @package  WordPress
   * @subpackage  Kelp
   */

  /**
   * Flush out the transients used in kelp_hasMultipleCategories.
   */
  add_action( 'edit_category', 'kelp_categoryTransientFlush' );
  add_action( 'save_post', 'kelp_categoryTransientFlush' );
  function kelp_categoryTransientFlush() {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }
    // Like, beat it. Dig?
    delete_transient( KELP_CATEGORY_TRANSIENT );
  }