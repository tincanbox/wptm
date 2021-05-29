<?php

$post_type = (@$query['post_type']
  ? $query['post_type']
  : (@$post_type ? $post_type : 'post'));

$group_name = 'post-type-'.$post_type;
$group_caption = $post_type;

$conf = WPTM::option('post_type');

if(!@$conf[$post_type] || !$conf[$post_type]['is_active']){
  WPTM::show_404();
}

# Fetch dummy post to generate $group_caption.
if($post_type){
  $q = new WP_Query('post_type='.$post_type.'&posts_per_page=1');
  if($q->have_posts()){
    $ps = $q->get_posts();
    if($ps){
      $d = $ps[0];
      $po = get_post_type($d);
      $p = ($po) ? get_post_type_object($po) : false;
      if($p){
        $group_caption = $p->label;
      }
    }
  }
  wp_reset_postdata();
}

WPTM::render('template/partial/article/list/group_default', array(
  'main_query' => @$main_query,
  'grouop_name' => $group_name,
  'group_caption' => $group_caption,
  'show_total_count' => @$show_total_count,
  'list_type' => @$conf[$post_type]['list_type'],
  'query' => array_merge(array(
    'posts_per_page'   => 6,
    #'offset'           => 0,
    #'category'         => '',
    #'category_name'    => '',
    'orderby'          => 'date',
    'order'            => 'DESC',
    #'include'          => '',
    #'exclude'          => '',
    #'meta_key'         => '',
    #'meta_value'       => '',
    'post_type'        => $post_type,
    #'post_mime_type'   => '',
    #'post_parent'      => '',
    #'author'     => '',
    'post_status'      => 'publish',
    'suppress_filters' => true 
  ), @$query ? $query : array())
));
