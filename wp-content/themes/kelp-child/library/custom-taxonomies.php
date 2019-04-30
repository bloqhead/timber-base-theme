<?php

/**
 * Custom taxonomies
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 *
 * @package Wordpress
 * @subpackage Kelp
 */

add_action( 'init', 'bsd_custom_taxonomies' );
function bsd_custom_taxonomies() {

	/** Test custom taxonomy */
	// register_taxonomy(
	// 	'genre',
	// 	'projects',
	// 	array(
	// 		'label' => __( 'Genre' ),
	// 		'rewrite' => array( 'slug' => 'genre' ),
	// 		'hierarchical' => true,
	// 	)
	// );

}
