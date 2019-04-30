<?php

/**
 * Timber, Setup and Configuration
 * 
 * @package  WordPress
 * @subpackage  Kelp
 */

add_action( 'init', 'kelpTimberCheck' );
function kelpTimberCheck() {
	if ( class_exists( 'Timber' ) ) return;
    
	/** 
	 * display an error on WP admin 
	 */
	if (is_admin()) {
		add_action( 'admin_notices', function() {
			$pluginTimberPath = esc_url( admin_url( 'plugins.php#timber' ) );
			$pluginPath = esc_url( admin_url( 'plugins.php') );
			echo "
				<div class=\"error\">
					<p>
						Timber not activated. Make sure you activate the plugin in <a href=\"{$pluginTimberPath}\">{$pluginPath}</a>
					</p>
				</div>
			";
		});

		return;
	}

	/**
	 * load a fallback page on the front end
	 * telling the user to install and activate
	 * the Timber plugin
	 */
	add_filter('template_include', function($template) {
		return get_template_directory() . '/no-timber.html';
	});
}

class KelpTimber extends TimberSite {

	function __construct() {
    add_filter( 'timber_context', array( $this, 'addToContext' ) );
    
		parent::__construct();
	}

	// Timber context additions
	function addToContext( $context ) {
		// main menu
		$context['main_menu'] = new TimberMenu( 'primary' );
		// footer menu
    $context['footer_menu'] = new TimberMenu( 'footer' );
    
		// shorthand for grabbing site attributes
		$context['site'] = $this;

		return apply_filters('kelp_timber_context', $context);
	}
}

if ( class_exists( 'Timber' ) ) {
  new KelpTimber();
}