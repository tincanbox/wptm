export default {
  init($) {
    $(document).on("click", ".gototop", function () {
      $("html,body").animate({ scrollTop: 0 });
    });
    return this;
  },
};
