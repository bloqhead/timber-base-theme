<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * @package  WordPress
 * @subpackage  Kelp
 * @since   Kelp 1.0
 */

$context = Timber::get_context();
$context['posts'] = Timber::get_posts();
$context['pagination'] = Timber::get_pagination();

$context['sidebarContent'] = Timber::get_sidebar('sidebar.php');

Timber::render('views/index.twig', $context);
