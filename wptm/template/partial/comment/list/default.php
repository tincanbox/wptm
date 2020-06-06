<?php

global $post;

if(post_password_required()){
  return;
}

#echo var_export(have_comments(), true);

?>

<div class="comment-list-area section">

  <?php if(have_comments()): ?>
    <h3 class="comment-list-title">
      <?php
        $comments_number = get_comments_number();
          printf(
            'レビュー <i class="badge">%1$s</i>',
            number_format_i18n( $comments_number )
          );
      ?>
    </h3>

    <?php the_comments_navigation(); ?>

    <ol class="comment-list">
      <?php
        wp_list_comments( array(
          'style'       => 'ol',
          'short_ping'  => true,
          'avatar_size' => 42,
        ) );
      ?>
    </ol><!-- .comment-list -->

    <?php the_comments_navigation(); ?>

  <?php endif; ?>

  <?php
  // If comments are closed and there are comments, let's leave a little note, shall we?
  if( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' )) :
    /* <p class="no-comments"><?php _e('Comments are closed.'); ?></p> */
  endif;
  ?>

  <?php

    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    $form = new WPTM_Comment_Form(array(
      'comment_form' => array(
        'fields' => array(
          'author' =>
            '<p class="comment-form-field comment-form-author '.($req ? 'required' : '').'">'
              #.'<label for="author">' . __('Name') . '</label> '
              #.($req ? '<span class="required">*</span>' : '')
              .'<div class="input-group">'
                .'<span class="input-group-addon"><i class="fa fa-user"></i></span>'
                .'<input'
                  .' class="form-control"'
                  .' id="author"'
                  .' name="author"'
                  .' type="text"'
                  .' placeholder="'.__('Name').'"'
                  .' value="' . esc_attr($commenter['comment_author']).'"'
                  .' size="30"' . $aria_req . ' />'
              .'</div>'
            .'</p>',

          'email' =>
            '<p class="comment-form-field comment-form-email '.($req ? 'required' : '').'">'
              #.'<label for="email">' . __('Email') . '</label> '
              #.($req ? '<span class="required">*</span>' : '')
              .'<div class="input-group">'
                .'<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>'
                .'<input'
                  .' class="form-control"'
                  .' id="email"'
                  .' name="email"'
                  .' type="text"'
                  .' placeholder="'. __('Email') .'"'
                  .' value="' . esc_attr($commenter['comment_author_email']).'"'
                  .' size="30"' . $aria_req . ' />'
              .'</div>'
            .'</p>',

          'url' =>
            '<p class="comment-form-field comment-form-url"><label for="url">' . __('Website') . '</label>' .
            '<input class="form-control" id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) .
            '" size="30" /></p>',
        ),
        'class_submit' => 'button btn btn-default',
        'title_reply' => '',
        'title_reply_to' => '',
        'title_reply_before' => '',
        'title_reply_after'  => '',
        'comment_notes_before' => '<p class="comment-notes">'. __( 'Your email address will not be published.').'</p>',
        'label_submit' => 'レビューする',
        'comment_field' => '<p class="comment-form-comment textarea"><label for="comment">' . _x('Comment', 'noun') .
            '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
                '</textarea></p>',
      )
    ));
    $form->set_field_config('comment', array('priority' => 99));
    $form->set_field_config('url', array('disabled' => true));
    $form->render();

  ?>

</div><!-- .comments-area -->
