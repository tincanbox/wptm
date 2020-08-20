<?php

// keep for pagi.
global $wp_query;

$wp_query = new WP_Query(array_merge(array(
  #'offset'           => 0,
  #'category'         => '',
  #'category_name'    => '',
  'orderby'          => 'date',
  'order'            => 'DESC',
  #'include'          => '',
  #'exclude'          => '',
  #'meta_key'         => '',
  #'meta_value'       => '',
  #'post_type'        => '',
  #'post_mime_type'   => '',
  #'post_parent'      => '',
  #'author'     => '',
  'post_status'      => 'publish',
  'suppress_filters' => true
), @$query ? $query : array()));

$posts = $wp_query->get_posts();

if(!$posts){
  if(@$query['post_type']){
    $wp_query = new WP_Query(array(
      'post_limit'       => 3,
      'posts_per_page'   => 3,
      'orderby'          => 'rand',
      'order'            => 'DESC',
      'post__not_in'     => @$query['post__not_in'],
      'post_type'        => $query['post_type'],
    ));
    $posts = $wp_query->get_posts();
  }
}

if($posts){

  $conf = array();
  foreach(array(
    'post_article_list_noimage_url',
    'post_show_time',
    'post_badge_new_interval'
  ) as $cn){
    $conf["opt_" . $cn] = @WPTM::option($cn);
  }

  $cls = '';

  if($list_type == 'simple_row'){
    $cls .= ' list-group';
  }

  if(@$show_total_count){
    ?>
    <div class="article-list-total-count theme-font-color-background-escape">
      <span><?php echo __('Search Result'); ?> : </span>
      <span class="count"><?php echo number_format($wp_query->found_posts); ?></span>
      <span></span>
    </div>
    <?php
  }

  ?><div class="article-list row <?php echo @$list_type ? 'list-type-'.$list_type : ''; ?> <?php echo $cls; ?>"><?php

  foreach($posts as $post){

    # Damn globals.
    setup_postdata($GLOBALS['post'] =& $post);

    if(!@$list_type || $list_type === 'default'){
      WPTM::render('template/partial/article/list/column/default', array_merge($conf, array(
        'post' => $post
      )));
    }else{
      WPTM::render('template/partial/article/list/column/'.$list_type, array_merge($conf, array(
        'post' => $post
      )));
    }

    wp_reset_postdata();
  }

  ?></div><?php

}else{
  ?><p class="section closing" style="color: #777; text-align: center; padding: 2.4em 1em; "><?php echo __("No query results."); ?></p><?php
}
