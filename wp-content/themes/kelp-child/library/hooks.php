<?php

/**
 * Wordpress Core/Plugin/Themes Hooks
 *
 * @package Wordpress
 * @subpackage Kelp
 */

if (!is_admin()) {
    // setup scripts and styles
    add_action( 'wp_enqueue_scripts', 'kelpChild_enqueue' );
} else {
    // Any Admin-specific hooks
}

function kelpChild_enqueue() {
	// styles
    wp_enqueue_style( 'kelp-child-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array('kelp-style'), 'all' );

    // scripts
    wp_enqueue_script( 'kelp-js', get_stylesheet_directory_uri() . '/assets/js/main.min.js', array(), '', true );
}