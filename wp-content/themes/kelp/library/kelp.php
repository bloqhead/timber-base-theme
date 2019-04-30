<?php

  /**
   * Backend Processing. These functions should never be called inside of Twig.
   * 
   * @package  WordPress
   * @subpackage  Kelp
   */

  add_action('after_setup_theme', 'kelpInitialize');
  function kelpInitialize() {
    /**
     * Basic clean up
     */
  
    // EditURI link
    remove_action('wp_head', 'rsd_link');
    // windows live writer
    remove_action('wp_head', 'wlwmanifest_link');
    // index link
    remove_action('wp_head', 'index_rel_link');
    // previous link
    remove_action('wp_head', 'parent_post_rel_link', 10, 0 );
    // start link
    remove_action('wp_head', 'start_post_rel_link', 10, 0 );
    // links for adjacent posts
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
    // WP version
    remove_action('wp_head', 'wp_generator');
    // remove WP version from RSS
    add_filter('the_generator', 'kelp_rss_version');
    // remove WP version from css
    add_filter('style_loader_src', 'kelp_remove_wp_ver_css_js', 9999 );
    // remove WP version from scripts
    add_filter('script_loader_src', 'kelp_remove_wp_ver_css_js', 9999 );
    // clean up gallery output
    add_filter('gallery_style', 'kelp_gallery_style');
    // clean up comment styles in the head
    add_action('wp_head', 'kelp_remove_recent_comments_style');
  
    // clean out all of the emoji stuff
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7 );
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    add_filter('tiny_mce_plugins', 'kelp_disable_emojicons_tinymce');
    // the DNS prefetch is related to emoji, so let's ditch that also
    remove_action('wp_head', 'wp_resource_hints', 2 );
  
    /**
     * Theme setup
     */
  
    // add language support
    load_theme_textdomain('kelp', get_template_directory() . '/languages');
  
    // add basic theme support
    add_theme_support('post-thumbnails');
    // add_theme_support('post-formats');
    add_theme_support('menus');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
  
    // enable HTML5 output
    add_theme_support('html5', [
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ]);

    // Actions & Filters
    add_action( 'wp_head', 'kelp_appIcons' );
  
    /**
     * Widgets, menus, styles and scripts
     */
  
    // setup widgets
    add_action('widgets_init', 'kelp_widgets_init');
  
    if (!is_admin()) {
      // setup scripts and styles
      add_action('wp_enqueue_scripts', 'kelp_scripts');
      add_action('wp_footer', 'kelp_browsersync');
    }
    
      /**
       * Setup menus
       */
      register_nav_menus(apply_filters('kelp_menu_locations', [
        'primary' => __('Primary', 'kelp'),
        'footer' => __('Footer', 'kelp')
      ]));
  }
  
  // Allow Browsersync, but only in debug mode.
  function kelp_browsersync () {
    if (WP_DEBUG) : ?>
      <script src="//localhost:35729/livereload.js"></script>
      <script id="__bs_script__">//<![CDATA[
        document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.8'><\/script>".replace("HOST", location.hostname));
      //]]></script>
    <?php endif;
  }
  
  /**
   * Cleanup
   */
  
  // remove WP version from RSS
  function kelp_rss_version() {
    return '';
  }
  
  // remove WP version from scripts
  function kelp_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=') )
      $src = remove_query_arg('ver', $src );
    return $src;
  }
  
  // remove injected CSS from recent comments widget
  function kelp_remove_recent_comments_style() {
    global $wp_widget_factory;
    if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
      remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
    }
  }
  
  // remove injected CSS from gallery
  function kelp_gallery_style( $css ) {
    return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
  }
  
  // disable emojis in TinyMCE
  function kelp_disable_emojicons_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
      return array_diff( $plugins, array('wpemoji') );
    }
    else {
      return array();
    }
  }
  
  function kelp_scripts() {
    $templateDirectoryURI = get_template_directory_uri();
  
    // styles
    if (apply_filters('kelp_include_grid', true)) {
      wp_enqueue_style('kelp-grid', $templateDirectoryURI . '/assets/css/grid.css');
    }
    // styles
    if (apply_filters('kelp_include_styles', true)) {
      wp_enqueue_style('kelp-style', $templateDirectoryURI . '/assets/css/style.css');
    }
    // scripts
    if (apply_filters('kelp_include_scripts', true)) {
      wp_enqueue_script('kelp-js', $templateDirectoryURI . '/assets/js/build.js', ['jquery'], '', true );
    }
  
    // comments
    if ( is_singular() && comments_open() && get_option('thread_comments') ) {
      wp_enqueue_script('comment-reply');#p
    }
  }
  
  // setup widgets
  function kelp_widgets_init() {
    $defaultSidebarConfig = apply_filters('kelp_primary_sidebar', [
      'name' => esc_html__('Sidebar', 'kelp'),
      'id' => 'sidebar',
      'description'   => esc_html__('Add widgets here.', 'kelp'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
    ]);

    define('KELP_DEFAULT_SIDEBAR_SLUG', $defaultSidebarConfig['id']);
    register_sidebar($defaultSidebarConfig);

    do_action('kelp_widgets_init');
  }

  /*
  * Favicons and app icons
  *
  * Need to make icons?
  * https://www.everyinteraction.com/resources/ios-10-11-app-icon-template-psd-sketch/
  *
  * @author Daryn St. Pierre <daryn@bigsea.co>
  *
  * @TODO confirm functionality
  *
  */
  function kelp_appIcons() {
    // Where are your icons?
    $iconLocations = apply_filters("kelp_icons_location", "/assets/img/icons/");
    
    /** File path required for file_exists() */
    $iconPath = get_stylesheet_directory() . trailingslashit($iconLocations);
    /** Image path for output */
    $iconURL = get_stylesheet_directory_uri() . trailingslashit($iconLocations);

    // Favicon
    if (file_exists("{$iconURL}/favicon.png")) {
      echo "<link rel=\"icon\" type=\"image/png\" href=\"{$iconURL}favicon.png\">" . PHP_EOL;

      if (file_exists("{$iconURL}favicon.ico")) {
        echo "<!--[if IE]><link rel=\"shortcut icon\" href=\"{$iconURL}favicon.ico\"><![endif]-->;" . PHP_EOL;
      }
    }

    /**
     * APPLE
     */

    $appleSizes = (array)apply_filters("kelp_icons_sizes_apple", array (
      "1024x1024", "180x180", "167x167", "152x152", "120x120", "87x87", "80x80",
      "76x76", "75x75", "66x66", "60x60", "58x58", "50x50", "44x44", "29x29",
      "25x25", "22x22"
    ));

    // Apple Icon Rendering
    foreach ($appleSizes as $size) {
      $currentIcon = apply_filters('kelp_icons_icon_name', "app-icon@{$size}.jpg", $size, "apple");

      if (file_exists($iconPath . $currentIcon)) {
        echo "<link rel=\"apple-touch-icon\" sizes=\"{$size}\" href=\"{$iconURL}{$currentIcon}\">" . PHP_EOL;
      }
    }

    /**
     * Microsoft
     */
    $msColor = apply_filters("kelp_icons_color_microsoft", "#FF858C");
    $msSizes = (array)apply_filters("kelp_icons_sizes_microsoft", array (
      "70x70", "150x150", "310x310", "500x500"
    ));

    // Microsoft Icon Rendering
    if ($msColor) {
      echo "<meta name=\"msapplication-TileColor\" content=\"{$msColor}\">" . PHP_EOL;
    }
    foreach ($msSizes as $size) {
      $currentIcon = apply_filters('kelp_icons_icon_name', "ms-icon@{$size}.png", $size, "microsoft");
      
      if (file_exists($iconPath . $currentIcon)) {
        echo "<meta name=\"msapplication-square{$size}logo\" content=\"{$iconURL}{$currentIcon}\">" . PHP_EOL;
      }
    }
  }
