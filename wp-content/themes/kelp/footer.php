<?php
/**
 * The footer, utilized by Plugins
 *
 * @package  WordPress
 * @subpackage  Kelp
 * @since   Kelp 1.0
 */

$context = Timber::get_context();
if ( !isset( $context ) ) {
	throw new \Exception( 'Missing Timber context. Not set in footer.' );
}

$context['content'] = ob_get_contents();
ob_end_clean();

$templates = array('views/plugin.twig');
Timber::render( $templates, $context );
