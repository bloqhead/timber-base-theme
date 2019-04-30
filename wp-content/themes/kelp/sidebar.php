<?php
/**
 * The Template for displaying the sidebar
 *
 * @package  Wordpress
 * @subpackage  Kelp
 */

$context = Timber::get_context();
$context['sidebarContent'] = Timber::get_widgets( KELP_DEFAULT_SIDEBAR_SLUG );

Timber::render( 'views/partials/sidebar.twig', $context );
