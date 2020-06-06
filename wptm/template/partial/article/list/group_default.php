<div class="article-list-group <?php echo @$group_name; ?>">

<?php

  if(@$show_group_caption && @$group_caption){
    ?><div class="article-list-group-caption-wrap">
      <h3 class="article-list-group-caption col-sm-12 col-md-8"><?php echo $group_caption; ?></h3>
    </div><?php
  }

  WPTM::render('template/partial/article/list/default', array(
    'list_type' => @$list_type,
    'show_total_count' => @$show_total_count,
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
      'post_type'        => 'post',
      #'post_mime_type'   => '',
      #'post_parent'      => '',
      #'author'     => '',
      'post_status'      => 'publish',
      'suppress_filters' => true
    ), @$query ? $query : array())
  ));

?>
</div>
<?php

