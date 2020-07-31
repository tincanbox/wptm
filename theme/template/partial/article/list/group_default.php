<?php

$query = @$query ? $query : array();

if(@$show_group_caption && @$group_caption){
  ?><div class="article-list-group-caption-wrap">
    <h3 class="article-list-group-caption theme-font-color-escape mb-3"><?php echo $group_caption; ?></h3>
  </div><?php
}

if(@$target_article_group){
  foreach($target_article_group as $c){
    switch($c['type']){
      case "category":
        $query['category__in'] = @$query['category__in'] ?: array();
        $query['category__in'][] = $c['object']->term_id;
      break;
      case "post_type":
        $query['post_type'] = $c['slug'];
      break;
      case "tag":
        $query['tag__in'] = @$query['tag__in'] ?: array();
        $query['tag__in'][] = $c['object']->term_id;
      break;
    }
  }
}

?>
<div class="article-list-group <?php echo @$group_name; ?>">
  <?php
  WPTM::render('template/partial/article/list/default', array(
    'main_query' => @$main_query,
    'list_type' => @$list_type,
    'show_total_count' => @$show_total_count,
    'query' => array_merge(array(
      'posts_per_page'   => 6,
      'suppress_filters' => true
    ), @$query ? $query : array())
  ));

?>
</div>
<?php

