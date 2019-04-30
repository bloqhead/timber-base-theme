//
// Mobile menu controls
//

(function($) {

  const targetMenu     = $('nav.main-navigation > ul.site-menu');
  const icon           = '<i class="far fa-angle-down no-transform mobile-menu-item-icon"></i>';
  const activeClass    = 'is-active';
  const dropdownItem   = targetMenu.find('li.has-dropdown');
  const dropdownLink   = dropdownItem.find('> a');

  /**
   * Adds an arrow to indicate that a menu has submenu items
   */
  const SubmenuIndicator = (link, icon) => {
    if ( link.find("i.mobile-menu-item-icon").length === 0 ) {
      dropdownLink.append(icon);
    }
  }

  /** 
   * Prepends the parent link to the submenu on small touch screens so that it's accessible
   */
  const ParentLinkCreator = () => {
    $('li.has-dropdown').each(() => {
      const link = $(this).find('> a');
      const subMenu = $(this).find('> a + .menu');
      const href = link.attr('href');
      const text = link.text();
      /** only append the link if it's not a placeholder...*/
      if (href !== "#") {
        subMenu.prepend(`<li class='menu-item'><a href='${href}'>${text}</a></li>`);
      }
    });
  }

  /**
   * Used for cleaning things up if they're not needed
   */
  const Cleanup = () => {
    let i = 0; // has to be mutable!
    if ((i === 0) && (window.innerWidth >= 1026)) {
      dropdownLink.find("i.mobile-menu-item-icon").remove();
      i = 1;
    }
    if ((i === 1) && (window.innerWidth < 1026)) {
      SubmenuIndicator(dropdownLink, icon);
      i = 0;
    }
  }

  /**
   * Run on load as long as the window width
   * requirements are met
   */
  $(window).on('load', () => {
    const hasTouch = 'ontouchstart' in document.documentElement;
    const windowWidth = window.innerWidth;
    if ( windowWidth <= 1025 && hasTouch ) {
      ParentLinkCreator();
      dropdownLink.on( 'click touchend', (e) => {
        $(this).toggleClass(activeClass);
        e.preventDefault();
      });
    }
  });

  /**
   * Implement the submenu indicator arrow
   * if the requirements are met, otherwise
   * clean things up a bit
   */
  $(window).on( 'load resize orientationchange', () => {
    SubmenuIndicator(dropdownLink, icon);
    Cleanup();
  });

})(jQuery);
