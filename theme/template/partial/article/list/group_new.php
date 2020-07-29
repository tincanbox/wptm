<?php

WPTM::render('template/partial/article/list/group_default', array(
'group_name' => $group_name,
'group_caption' => $group_caption,
'show_total_count' => @$show_total_count,
'list_type' => @$list_type,
'query' => array_merge(array(
    'posts_per_page'   => 6,
    #'offset'           => 0,
    #'category'         => '',
    'category_name'    => '',
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
))
));