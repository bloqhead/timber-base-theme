// 
// Hamburger trigger
// 

(function($) {

  $('.hamburger').on( 'click touchend', (e) => {
    $(this).toggleClass('is-active');
    $('body').toggleClass('is-locked');
    $('.main-navigation').toggleClass('is-active');
    $('.menu-bar').toggleClass('is-active');
    e.preventDefault();
  });

  // 
  // Close out the menu when the ESC is pressed
  // 
  $(document).keyup( (e) => {
    if (e.keyCode === 27) {
      $('.hamburger').removeClass('is-active');
      $('body').removeClass('is-locked');
      $('.main-navigation').toggleClass('is-active');
      $('.menu-bar').removeClass('is-active');
    }
  });

})(jQuery);
