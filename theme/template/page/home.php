<?php /* WPTM::render('template/partial/article/list/group_category', array(
  'list_type' => 'simple_row',
  'query' => array(
    'category_name' => 'notification',
  )
)); */ ?>

<?php 

$link_read_more_label = ($v = WPTM::option('post_article_list_read_more_label')) ? $v : 'More &raquo;';

$priority = array();
$cs = WPTM::option('category_for_article_manage');
$cat_c = WPTM::option('category');

if($cs){
  foreach($cs as $c => $is_active){
    if($is_active){
      $p = @$cat_c[$c];
      $k = (int)@$p['display_priority'];
      while(isset($priority[$k])){
        $k += 1;
      }
      $p['slug'] = $c;
      $priority[$k] = $p;
    }
  }
}

ksort($priority);

foreach($priority as $p => $s){
  ?>
  <?php $c = get_category_by_slug($s['slug']); ?>
  <?php if($c){ ?>
    <div class="category-<?php echo $c->slug; ?> mb-5">
      <div class="article-list-group-caption-wrap row">
        <h3 class="article-list-group-caption theme-font-color col-sm-12 col-md-10 flex">
          <?php if(@$s['icon']){ ?>
            <span class="wptm-category-icon align-middle" style="background-image: url(<?php echo $s['icon']; ?>);"></span>
          <?php } ?>
          <span class="align-middle"><?php echo $c->name; ?></span>
        </h3>
        <a
          href="<?php echo get_category_link($c->cat_ID); ?>"
          class="theme-font-color col-sm-12 col-md-2 text-right ml-auto center">
          <img src="<?php echo get_bloginfo('template_directory'); ?>/static/image/arrow-circle-right.png">
        </a>
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
          class="theme-font-color"
          style="margin-bottom: 4.2em;"><?php echo __($link_read_more_label); ?> <?php echo $c->name; ?></a>
      </div>
    </div>
  <?php } ?>
  <?php
}

?>
