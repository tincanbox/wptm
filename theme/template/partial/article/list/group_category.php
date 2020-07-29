<?php
if(@$query){
  $category = @$query['category_name'] ? $query['category_name'] : @$category;
}

$cats = (@$category ? (is_array($category) ? $category : array($category)) : array(''));

foreach($cats as $cat){

  $group_caption = '';
  $group_name = 'category-'.$cat;

  if($cat){
    $cat_data = get_category_by_slug($cat);

    if($cat_data){
      $group_caption = $cat_data->name;
    }
  }

  WPTM::render('template/partial/article/list/group_default', array(
    'main_query' => @$main_query,
    'group_name' => $group_name,
    'group_caption' => $group_caption,
    'show_total_count' => @$show_total_count,
    'show_group_caption' => @$show_group_caption,
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
