export default {
  init($) {

    const HUMBLE_HEIGHT = (screen.height / 3);

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
      let target = $('.wait-humble');
      if (scroll_top > HUMBLE_HEIGHT) {
        target.addClass('humble');
        if (scroll_top > HUMBLE_HEIGHT * 3 * 1.2) {
          target.filter('.more-humble').addClass('d-none');
        } else {
          target.filter('.more-humble').removeClass('d-none');
        }
      } else {
        $('.wait-humble').removeClass('humble');
      }
    }
    $(window).on("scroll", () => {
      init_header();
    });
    init_header();

    return this;
  },
};