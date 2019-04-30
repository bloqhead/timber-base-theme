<?php
/**
 * Custom post types
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 *
 * @package  Wordpress
 * @subpackage Kelp
 */

add_action( 'init', 'kelp_customPostTypes', 0 );
function kelp_customPostTypes() {

	/** Test custom post type */
	// register_post_type( 'books',
	// 	array(
	// 		'labels' => array(
	// 			'name' => __( 'Books' ),
	// 			'singular_name' => __( 'Book' ),
	// 			'add_new' => __( 'Add Book' ),
	// 			'add_new_item' => __( 'Add a Book' )
	// 		),
	// 		/** Select an icon: https://developer.wordpress.org/resource/dashicons/ */
	// 		'menu_icon' => 'dashicons-admin-page',
	// 		'public' => true,
	// 		'has_archive' => true,
	// 		'supports' => array (
	// 			'title',
	// 			'thumbnail',
	// 			'page-attributes',
	// 			'editor'
	// 		),
	// 	)
	// );

}
