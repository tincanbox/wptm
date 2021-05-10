export default {
  init($) {
    const DOM_HEADER = $('#header');
    const HEADER_HEIGHT = DOM_HEADER.height();

    $("body").on("click", ".gototop", function () {
      $("html,body").animate({ scrollTop: 0 });
    });

    setTimeout(() => {
      $(".invisible-onload").addClass("loaded")
    }, 1400);

    window.onbeforeunload = null;
    $(window).on("beforeunload", (event) => {
      event.preventDefault();
      $(".invisible-onload").removeClass("loaded")
    });

    function init_header(){
      let scroll_top = $(window).scrollTop();
      if (scroll_top > HEADER_HEIGHT) {
        DOM_HEADER.addClass('humble');
      } else {
        DOM_HEADER.removeClass('humble');
      }
    }
    $(window).on("scroll", (e) => {
      init_header();
    });
    init_header();

    return this;
  },
};