$(function(){

  $.fn.scrollfollow = function(op){

    var $el = $(this);

    var Conf = $.extend({
      wrapper      : $(document),
      top          : op.top || 0,
      bottom       : op.bottom || 0,
      start_margin : 0,
      stop_margin  : 0,
      anim_show    : function(el){ el.stop().fadeTo('fast', 1); },
      anim_hide    : function(el){ el.stop().fadeTo('fast', 0); },
      anim_length  : 240,
      toggle_anim  : function(frame, el){ el.css({opacity: frame / Conf.anim_length}) }
    }, op);

    Conf.observer = (Conf.observer || Conf.wrapper);

    var Vars = $.extend({}, {
      available_top : 0,
      now_top       : 0,
      prev_top      : 0,
      animating     : false,
      scrolling     : null,
      window_height : window.innerHeight,
      initial_width : $el.width(),
    }, Conf );


    function main(e){

      // This needs window related position cause of "position:fixed"
      var st = Vars.observer.scrollTop();
      var t  = get_top( st, Vars.window_height );

      $el.css({
        "height": Vars.visible_height,
        "width": Vars.initial_width,
      });

      if( parseInt(Vars.anim_length) ){
        if( t < Vars.start_margin + Conf.anim_length ){
          toggle_anim( t - Vars.start_margin, $el );
        }else{
          $el.css({
            "opacity": 1
          });
        }
      }else{
        toggle_anim( t - Vars.start_margin, $el );
      }

      if( t > Vars.available_top ){
        stop_at(Vars.available_top);
        return;
      }

      if( t > Vars.start_margin ){
        movable();
      }else if( st < Vars.start_margin ){
        stop_at(Vars.start_margin);
        return;
      }

      $el.css({
        "position" : "fixed",
        "bottom"   : Conf.bottom + "px",
        "overflow-x": "hidden",
        "overflow-y": "scroll"
      });

      Vars.now_top = t;
    }

    /**-------------------------------------------
     * Get val
     *
     */
    function get_top(current_top, window_height){
      return parseInt(current_top)
           + ( parseInt(window_height) - parseInt($el.height()) - parseInt(Conf.bottom || 0) );
    }

    function get_available_top(){
      return (Vars.wrapper.height() - Vars.stop_margin) - $el.height() - parseInt(Conf.bottom || 0);
    }


    /**------------------------------------------
     * Element's actions
     *
     */
    function toggle_anim(f){
      Conf.toggle_anim( parseInt(f), $el);
    }

    function stop_at(top){
      console.log("stop_at", top);
      $el.css({
        "position" : "absolute",
        "top"      : top + "px",
        "bottom"   : "",
        "overflow-y": "",
        "overflow-x": "",
      });
    }

    function movable(){
      $el.css({
        "position" : "fixed",
        "top"      : "",
        "bottom"   : Conf.bottom + "px"
      });
    }

    /**-------------------------------------------
     *
     */

    /**
     * Change Vars when window size has been changed or loaded.
     *
     */
    function init_var(){
      Vars.visible_height = (Vars.window_height) - parseInt(Conf.wrapper.offset().top);
      Vars.available_top = get_available_top();
      Vars.window_height = window.innerHeight;
      Vars.scroll_top  = Conf.observer.scrollTop();
      var t = get_top(Vars.scroll_top, Vars.window_height);
      console.log(Vars.start_margin);
      console.log("conf", Conf);
      console.log("vars", Vars);
    }

    /**
     * Force new position when window size has been changed.
     *
     */
    function init_pos(t){
      var to = get_top(t, window.innerHeight);
      console.log("initpos", to, Vars);
      (to < Vars.available_top && to > Vars.start_margin && (t != to) )
        && $el.css({
          "top" : to + "px"
        });
    }


    /**--------------------------------------------
     * Events.
     *
     */
    (Conf.observer || Conf.wrapper).on('scroll', function(e){
      Vars.scrolling && (clearTimeout(Vars.scrolling));
      Vars.scrolling = setTimeout(init_var, 100);
      main(e);
    });

    $(window).on('resize', function(e){
      init_var();
      init_pos( Vars.wrapper.scrollTop() );
      main(e);
    });

    $(window).on('load', function(e){
      init_var();
      init_pos( Vars.wrapper.scrollTop() );
      setTimeout(function(){ main(e); }, 100);
    });

  }

  //$("#fix-go-top").css({
  //  opacity : 0,
  //  height  : "70px"
  //}).scrollfollow({
  //  wrapper      : $(document),  // Wrapper element as jQuery object.
  //  anim_length  : 360,          // Distance which triggers 'toggle_anim' callback.
  //  bottom       : 20,           // Distance from stop_margin.
  //  start_margin : 540,          // Margin from scrollTop:0 .
  //  stop_margin  : 200,          // Distance from wrapper's bottom.
  //  toggle_anim  : function(frame, el){ /* CALLBACK */ }
  //});
});


