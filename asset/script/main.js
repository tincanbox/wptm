export default {
  init($) {
    $("body").on("click", ".gototop", function () {
      $("html,body").animate({ scrollTop: 0 });
    });

    setTimeout(() => {
      $(".invisible-onload").addClass("loaded")
    }, 1400);

    window.onbeforeunload = null;
    $(window).on("beforeunload", () => {
      event.preventDefault();
      $(".invisible-onload").removeClass("loaded")
    });

    return this;
  },
};