<?php
/**
 * Big Sea functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package  WordPress
 * @subpackage  Kelp
 */

/**
 * Timber
 *
 * If you want to add things to Timber's context or do
 * any other Timber additions and extensions, they go here.
 */
require get_template_directory() . '/library/timber.php';

/**
 * Theme Setup
 *
 * This is where all of the head cleanup is handled, as well
 * as styles and scripts, image sizes, widget areas, etc.
 */
require get_template_directory() . '/library/kelp.php';

/**
 * Common internal-use functions
 */
require get_template_directory() . '/library/common.php';

/**
 * Admin Only
 */
if (is_admin()) {
  require get_template_directory() . '/library/admin.php';
}

/**
 * Custom template tags
 */
require get_template_directory() . '/library/template-tags.php';
