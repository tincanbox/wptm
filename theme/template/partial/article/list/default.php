<?php

global $wp_query;

$wp_query = new WP_Query(array_merge(array(
  #'posts_per_page'   => 10,
  #'offset'           => 0,
  #'category'         => '',
  #'category_name'    => '',
  'orderby'          => 'date',
  'order'            => 'DESC',
  #'include'          => '',
  #'exclude'          => '',
  #'meta_key'         => '',
  #'meta_value'       => '',
  'post_type'        => 'post',
  #'post_mime_type'   => '',
  #'post_parent'      => '',
  #'author'     => '',
  'post_status'      => 'publish',
  'suppress_filters' => true
), @$query ? $query : array()));

$posts = $wp_query->get_posts();


if($posts){

  $cls = '';

  if($list_type == 'simple_row'){
    $cls .= ' list-group';
  }

  if(@$show_total_count){
    ?>
    <div class="article-list-total-count theme-font-color-background-escape">
      検索結果: <span class="count"><?php echo number_format($wp_query->found_posts); ?></span><span>件</span>
    </div>
    <?php
  }

  ?><div class="article-list row <?php echo @$list_type ? 'list-type-'.$list_type : ''; ?> <?php echo $cls; ?>"><?php

  foreach($posts as $post){

    # Damn globals.
    setup_postdata($GLOBALS['post'] =& $post);

    if(!@$list_type || $list_type === 'default'){
      WPTM::render('template/partial/article/list/column/default', array(
        'post' => $post
      ));
    }else{
      WPTM::render('template/partial/article/list/column/'.$list_type, array(
        'post' => $post
      ));
    }

    wp_reset_postdata();
  }

  ?></div><?php

}else{
  ?><p style="color: #777; padding: 1.4em; text-align: center; font-size: 1.4em;">該当する記事が見つかりませんでした。</p><?php
}
