<?php

$post_type = null;
$categories = array();

if($post){
  $post_type = get_post_type_object(get_post_type($post));
  $categories = get_the_category($post->ID);
  $categories = $categories ? $categories : array();
}

if($post_type){

  $template = 'post_type';
  $group_caption = $post_type->labels->name;

  $cats = array();
  foreach($categories as $cat){
    $cats[] = $cat->slug;
  }

  if(@$group_caption){
    ?>
    <h4 class="article-group-caption mb-2"><?php echo __($group_caption); ?></h4>
    <?php
  }

  WPTM::render('template/partial/article/list/group_'.$template, array(
    'main_query' => @$main_query,
    'list_type' => @$list_type,
    'group_caption' => @$group_caption,
    'show_total_count' => @$show_total_count,
    'query' => array_merge(array(
      'posts_per_page'   => 3,
      #'offset'           => 0,
      #'category'         => '',
      'category_name'    => implode(',', $cats),
      'orderby'          => 'date',
      'order'            => 'DESC',
      #'include'          => '',
      'exclude'          => $post->ID,
      #'meta_key'         => '',
      #'meta_value'       => '',
      'post_type'        => $post_type->name,
      #'post_mime_type'   => '',
      #'post_parent'      => '',
      #'author'     => '',
      'post_status'      => 'publish',
      'suppress_filters' => true
    ), @$query ? $query : array())
  ));

}
