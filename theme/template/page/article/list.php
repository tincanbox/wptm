<div class="container">
<?php

global $wp_query;

WPTM::render('template/partial/article/list/group_'.(@$archive_type ? $archive_type : 'default'), array(
  'main_query' => $main_query,
  'list_type' => 'with_picture',
  'show_total_count' => @$show_total_count,
  'show_group_caption' => true,
  'query' => @$query
));

WPTM::render('template/partial/article/list/module/pagination');

?>
</div>