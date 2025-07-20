$(document).ready(function(){
  // FAQページ質問をクリックして回答を開く
  $('.faq-content-item-question').click(function(){
    if($(this).hasClass('active')) {
      $(this).removeClass('active');
      $(this).closest('.faq-content-item').find('.faq-content-item-answer').slideUp(300);
    } else {
      $(this).addClass('active');
      $(this).closest('.faq-content-item').find('.faq-content-item-answer').slideDown(300);
    }
  });
});