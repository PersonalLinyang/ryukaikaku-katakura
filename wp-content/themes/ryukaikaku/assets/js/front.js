$(document).ready(function(){
  var max_length = 0;
  $('.front-mainvisual-logo-line path').each(function(){
    var length = $(this)[0].getTotalLength();
    if(length > max_length) {
      max_length = length;
    }
    $(this).css('stroke-dasharray', length + 'px').css('stroke-dashoffset', length + 'px').css('animation', 'logo-line-anm ' + (length * 5) + 'ms linear forwards');
  });
  window.setTimeout(function() {
    $('.front-mainvisual-logo-fill').addClass('active');
    window.setTimeout(function() {
      $('.front-mainvisual-logo-back').addClass('hidden');
    }, 3000);
  }, max_length * 3);
});