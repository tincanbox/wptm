<?php
if(@$query){
  $tags = array($query['tag']);
}

foreach($tags as $e){

  $group_caption = '';
  $group_name = 'tag-'.$e;

  if($e){
    $tag = get_tags(array('slug' => $e));
    if($tag){
      $group_caption = sprintf(__("Tag: %s"), $tag[0]->slug);
    }
  }

  WPTM::render('template/partial/article/list/group_default', array(
    'main_query' => @$main_query,
    'group_name' => $group_name,
    'group_caption' => $group_caption,
    'show_total_count' => @$show_total_count,
    'list_type' => @$list_type,
    'query' => array_merge(array(
      'posts_per_page'   => 6,
      #'offset'           => 0,
      #'category'         => '',
      'category_name'    => (@$cat ? (is_array($cat) ? implode(',', $cat) : $cat) : ''),
      'orderby'          => 'date',
      'order'            => 'DESC',
      #'include'          => '',
      #'exclude'          => '',
      #'meta_key'         => '',
      #'meta_value'       => '',
      #'post_type'        => 'post',
      #'post_mime_type'   => '',
      #'post_parent'      => '',
      #'author'     => '',
      'post_status'      => 'publish',
      'suppress_filters' => true 
    ), @$query ? $query : array())
  ));

}
