<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
  <div class="input-group search-box">
    <input type="search" class="form-control" placeholder="<?php echo __('Search'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    <span class="input-group-append">
      <button type="submit" class="btn btn-default">
        <span><i class="fa fa-search"></i></span>
      </button>
    </span>
  </div>
</form>

<?php

if(get_search_query()){

  $cat_ids = array();
  $include_posttype_list = array();

  $conf = WPTM::option('category');
  foreach($conf as $sl => $c){
    if($c && @$c['search_excluded']){
      $c = get_category_by_slug($sl);
      if($c){
        $cat_ids[] = $c->cat_ID;
      }
    }
  }

  $conf = WPTM::option('posttype');
  foreach($conf as $sl => $c){
    if($c && !@$c['search_excluded']){
      if($c){
        $include_posttype_list[] = $sl;
      }
    }
  }

  WPTM::render('template/page/article/list', array(
    'main_query' => $main_query,
    'show_total_count' => true,
    'archive_type' => 'default',
    'list_type' => 'with_picture',
    'query' => array_merge($main_query->query, array(
      'post_type' => $include_posttype_list,
      'category__not_in' => $cat_ids
    ))
  ));

}

?>
