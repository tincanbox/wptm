<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
  <div class="input-group">
    <input type="search" class="form-control" placeholder="" value="<?php echo get_search_query(); ?>" name="s" />
    <span class="input-group-btn">
      <button type="submit" class="btn btn-default">
        <i class="fa fa-search"></i>&nbsp; 検索</span>
      </button>
    </span>
  </div>
</form>

<?php

if(get_search_query()){

  $exclude = WPTM::option('category_list_search_excluded');
  $cat_ids = array();
  if($exclude){
    foreach($exclude as $sl => $b){
      if($b){
        $c = get_category_by_slug($sl);
        if($c){
          $cat_ids[] = $c->cat_ID;
        }
      }
    }
  }

  WPTM::render('template/page/article/list', array(
    'show_total_count' => true,
    'archive_type' => 'default',
    'list_type' => 'with_picture',
    'query' => array_merge($main_query->query, array('category__not_in' => $cat_ids))
  ));

}

?>
