<div class="container">
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

if(@$main_query->query){

  WPTM::render('template/page/article/list', array(
    'main_query' => @$main_query,
    'show_total_count' => true,
    'archive_type' => 'default',
    'list_type' => 'with_picture',
    'query' => $main_query->query
  ));

}

?>
</div>