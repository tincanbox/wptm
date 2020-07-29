<?php /* WPTM::render('template/partial/article/list/group_category', array(
  'list_type' => 'simple_row',
)); */ ?>

<?php 

$link_read_more_label = ($v = WPTM::option('post_article_list_read_more_label')) ? $v : 'More &raquo;';

$priority = array();
$cat_c = WPTM::option('category');

if($cat_c){
  $stack = array();
  foreach($cat_c as $slug => $p){
    $is_active = !!@$p['is_active'];
    if($is_active){
      $k = (int)@$p['display_priority'];
      if(array_key_exists($k, $stack)) $stack[$k] = array();
      $p['slug'] = $slug;
      $stack[$k][] = $p;
    }
  }
  foreach($stack as $pri => $list){
    foreach($list as $p) $priority[] = $p;
  }
}

ksort($priority);

foreach($priority as $p => $s){
  ?>
  <?php $c = get_category_by_slug($s['slug']); ?>
  <?php if($c){ ?>
    <div class="category-<?php echo $c->slug; ?> mb-5">
      <div class="article-list-group-caption-wrap row mt-1 mb-4">
        <h3 class="article-list-group-caption theme-font-color-escape col-10 col-md-11 mb-0 rack-board">
          <?php if(@$s['icon']){ ?>
            <i class="theme-article-icon mr-1" style="background-image: url(<?php echo $s['icon']; ?>);"></i>
          <?php } ?>
          <span class="mr-3"><?php echo $c->name; ?></span>
          <a
            class="theme-font-color-escape animatable attractive d-inline-block"
            href="<?php echo get_category_link($c->cat_ID); ?>">
            <div class="theme-font-color-escape" style="width:1em; height:1em; transform:rotate(90deg);">
              <svg id="svg" viewBox="0 0 512 512"><use xlink:href="#chevron-up"></use></svg>
            </div>
          </a>

        </h3>
      </div>
      <?php WPTM::render('template/partial/article/list/group_category', array(
        'list_type' => 'with_picture',
        'query' => array(
          'category_name' => $c->slug,
          'posts_per_page' => @$s['article_count'] || 3
        )
      )); ?>
      <div class="text-right">
        <a
          href="<?php echo get_category_link($c->cat_ID); ?>"
          class="theme-font-color-escape"
          style="margin-bottom: 4.2em;"><?php echo __($link_read_more_label); ?> <?php echo $c->name; ?></a>
      </div>
    </div>
  <?php } ?>
  <?php
}

?>
