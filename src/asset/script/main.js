$(function(){

  $(window).on('load', init);

  function init(){
    $('a.gototop').on('click', function(){
      $('body').animate({scrollTop: 0});
    });
  }

});
