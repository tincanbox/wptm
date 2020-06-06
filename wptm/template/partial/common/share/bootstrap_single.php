<div class="button-group-sharing" style="padding-bottom: .8em;">

  <?php WPTM::render('template/partial/common/share/button_twitter', array(
    'post' => $post,
    'url' => get_permalink($post->ID),
    'text' => get_bloginfo('title').' | '.$post->post_title."\n"
  )); ?>

  <?php WPTM::render('template/partial/common/share/button_facebook', array(
    'post' => $post
  )); ?>

  <?php WPTM::render('template/partial/common/share/button_line', array(
    'post' => $post
  )); ?>

</div>
