<?php

global $wp_query;

if(is_post_type_archive()){
  $archive_type = 'post_type';
}elseif(is_category()){
  $archive_type = 'category';
}elseif(is_tag()){
  $archive_type = 'tag';
}else{
  $archive_type = 'default';
}

$q['posts_per_page'] = 12;

WPTM::render('template/layout', array(
  'yield' => WPTM::template('template/page/article/list', array(
    'main_query' => $wp_query,
    'archive_type' => $archive_type,
    'query' => $wp_query->query
  )),
));
