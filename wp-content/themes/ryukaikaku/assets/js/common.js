$(document).ready(function(){
  
  // [SP]ヘッダーメニューハンドラーをクリック
  $('.header-menu-handler').click(function(){
    if($(this).hasClass('active')) {
      $(this).removeClass('active');
      $('.header-menu').slideUp();
    } else {
      $(this).addClass('active');
      $('.header-menu').slideDown();
    }
  });
  
  // [SP]ヘッダーメニューサブメニューありの要素をクリック
  $('.header-menu-item.has-sub').click(function(){
    if($(this).hasClass('active')) {
      $(this).removeClass('active');
      $(this).find('.header-menu-subarea').slideUp();
    } else {
      $(this).addClass('active');
      $(this).find('.header-menu-subarea').slideDown();
    }
  });
  
  // ページ内リンククリック遷移
  $('a[href^="#"]').click(function(){
    var href = $(this).attr('href'),
        target = $(href === '#' || href === '' ? 'html' : href),
        position = target.offset().top,
        height_header = $('.header').height();
     $('html, body').animate({scrollTop:position-height_header-20}, 500, "swing");
     return false;
  });
  
});