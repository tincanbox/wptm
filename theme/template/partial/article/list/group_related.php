<?php

$query = @$query ?: array();

if(@$group_caption){
  ?>
  <h4 class="article-group-caption mb-2"><?php echo $group_caption; ?></h4>
  <?php
}

WPTM::render('template/partial/article/list/group_default', array(
  'main_query' => @$main_query,
  'list_type' => @$list_type,
  'show_total_count' => @$show_total_count,
  'query' => array_merge(array(
  ), $query)
));