<?php

class comment_field_star_rating {

  var $input_name = 'five_star_rating';

  function __construct(){
    add_filter('comment_form_fields', array($this, 'push_field_to_default'));
    add_action('comment_post', array($this, 'save_comment_meta_data') );
    add_action('add_meta_boxes_comment', array($this, 'extend_comment_add_meta_box') );
    add_filter('comment_text', array($this, 'modify_comment'));
    add_action('edit_comment', array($this, 'extend_comment_edit_metafields') );
  }

  function comment_field_star_rating_render_stars($selected = 0, $editable = false){
?><style>

  .comment-form-field-five-star-rating input:checked + .fa {
    display: none;
  }

  .comment-form-field-five-star-rating .star {
    font-size: 1.4em;
    margin: .2em;
  }

  .comment-form-field-five-star-rating .single-star input {
    height: 0px;
    width: 0;
    display: block;
    overflow: hidden;
    position: fixed;
    left: -9999px;
  }

  .comment-form-field-five-star-rating .fa-star-o {
    color: #aaa;
  }

  .comment-form-field-five-star-rating .star.active,
  .editable .comment-form-field-five-star-rating .fa-star-o:hover,
  .comment-form-field-five-star-rating .fa-star {
    color: #E6E65F;
    text-shadow: 0 0 2px rgba(0,0,0,.4);
  }

  </style>

  <div class="comment-form-field-five-star-rating <?php echo $editable ? 'editable' : ''; ?>">
  <label for="rating"></label>
    <span class="stars">
<?php

    //Current rating scale is 1 to 5. If you want the scale to be 1 to 10, then set the value of $i to 10.
    for($i=1; $i <= 5; $i++){
?><label class="single-star">
        <i class="star fa <?php echo $i <= $selected ? 'fa-star' : 'fa-star-o'; ?>"></i>
        <?php if($editable){ ?>
          <input style="height: 0; width: 0;" type="radio" name="<?php echo $this->input_name; ?>" value="<?php echo $i; ?>"/>
        <?php } ?>
        </label><?php
    }

?>
    </span>
    </div><?php

  }

  function modify_comment( $text ){
    $ok = false;
    foreach(debug_backtrace() as $d){
      if($d['function'] == 'wp_list_comments'){
        $ok = true;
        break;
      }
    }
    if($ok){
      $cid = get_comment_ID();
      $m = get_comment_meta($cid, $this->input_name);
      if(count($m)){
        $m = $m[0];
        $bf = $this->comment_field_star_rating_render_stars($m, false);
      }
    }
    return $text;
  }

  function extend_comment_edit_metafields( $comment_id ) {
    if(
      !isset($_POST['extend_comment_update'])
      || !wp_verify_nonce($_POST['extend_comment_update'], 'extend_comment_update')
    ){
    return;
    }

    if( (isset($_POST[$this->input_name])) && ($_POST[$this->input_name] != '') ){
      $rating = wp_filter_nohtml_kses($_POST[$this->input_name]);
      update_comment_meta( $comment_id, $this->input_name, $rating );
    }else{
      delete_comment_meta( $comment_id, $this->input_name);
    }
  }


  #
  #
  #
  function push_field_to_default($fields) {
    $fields[$this->input_name] = $this->render_field();
    return $fields;
  }



  #
  #
  #
  function render_field() {
    @ob_start();

    echo '<div class="editable">';
    $this->comment_field_star_rating_render_stars(0, true);
    echo '</div>';

    print_r("<script>
      $(function(){
        var stars = $('.comment-form-field-five-star-rating .single-star');

        function fill(count, c){
          var count = parseInt(count);
          for(var i = 1; i <= stars.length; i++){
            var l = $('input[name=".$this->input_name."][value='+ i +']');
            var star = l.siblings('.star');
            if(i <= count){
              if(c){
                star.addClass(c);
              }else{
                star.removeClass('fa-star-o');
                star.addClass('fa-star');
              }
            }else{
              if(c){
                star.removeClass(c);
              }else{
                star.removeClass('fa-star');
                star.addClass('fa-star-o');
              }
            }
          }
        }

        stars.each(function(){
          var el = $(this);
          var icon  = el.find('.star');
          var input = el.find('input');
          el.hover(
            function(){
              fill(input.val(), 'active');
            },
              function(){
                fill(0, 'active');
              }
          );
          input.on('change', function(){
            var el = $(this);
            var count = el.val();
            var checked = el.prop('checked');
            checked && fill(count);
          });
        });
      });
      </script>");

    return ob_get_clean();
  }

  function save_comment_meta_data( $comment_id ) {
    if( (isset($_POST[$this->input_name])) && ($_POST[$this->input_name] != '') ){
      $rating = wp_filter_nohtml_kses($_POST[$this->input_name]);
      add_comment_meta($comment_id, $this->input_name, $rating);
    }
  }

  function extend_comment_add_meta_box() {
    add_meta_box( 'title', __( 'Comment Metadata - Extend Comment' ), array($this, 'extend_comment_meta_box'), 'comment', 'normal', 'high' );
  }

  function extend_comment_meta_box ( $comment ) {
    $rating = get_comment_meta( $comment->comment_ID, $this->input_name, true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false ); ?>

    <p>
      <label for="rating"><?php _e( 'Rating: ' ); ?></label>
      <span class="commentratingbox"><?php

    for( $i=1; $i <= 5; $i++ ) {
      echo '<span class="commentrating"><input type="radio" name="'.$this->input_name.'" id="rating" value="'. $i .'"';
      if ( $rating == $i ) echo ' checked="checked"';
      echo ' />'. $i .' </span>';
    } ?>

    </span>
    </p><?php

  }

}

new comment_field_star_rating();

