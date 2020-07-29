<?php

if(@$query){
  $default_posts_per_page = get_option( 'posts_per_page' );
  $query['posts_per_page'] = $default_posts_per_page;
}

WPTM::render('template/partial/article/list/group_'.(@$archive_type ? $archive_type : 'default'), array(
  'main_query' => $main_query,
  'list_type' => 'with_picture',
  'show_total_count' => @$show_total_count,
  'show_group_caption' => true,
  'query' => @$query
));

WPTM::render('template/partial/article/list/module/pagination');
