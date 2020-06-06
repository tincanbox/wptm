<?php /* WPTM::render('template/partial/article/list/group_category', array(
  'list_type' => 'simple_row',
  'query' => array(
    'category_name' => 'notification',
  )
)); */ ?>

<?php $cs = WPTM::option('category_for_article_manage');

$link_read_more_label = ($v = WPTM::option('post_article_list_read_more_label')) ? $v : 'More &raquo;';

$priority = array();
$cat_c = WPTM::option('category');

if($cs){
  foreach($cs as $c => $p){
    if($p){
      if(isset($cat_c[$c])){
        $p = $cat_c[$c];
        $k = (int)@$p['display_priority'];
        if(isset($priority[$k])){
          $k += 1;
        }
        $p['slug'] = $c;
        $priority[$k] = $p;
      }
    }
  }
}

ksort($priority);

foreach($priority as $p => $s){
  ?>
  <?php $c = get_category_by_slug($s['slug']); ?>
  <?php if($c){ ?>
    <div class="category-<?php echo $c->slug; ?>">
      <div class="article-list-group-caption-wrap">
        <h3 class="article-list-group-caption theme-font-color-background-escape col-sm-12 col-md-8"><?php echo $c->name; ?></h3>
        <a
          href="<?php echo get_category_link($c->cat_ID); ?>"
          class="link-read-more theme-font-color-background-escape col-sm-12 col-md-4 hidden-xs"><?php echo $link_read_more_label; ?></a>
      </div>
      <?php WPTM::render('template/partial/article/list/group_category', array(
        'list_type' => 'with_picture',
        'query' => array(
          'category_name' => $c->slug,
          'posts_per_page' => $s['article_count']
        )
      )); ?>
            <a
              href="<?php echo get_category_link($c->cat_ID); ?>"
              class="link-read-more theme-font-color-background-escape col-sm-12 col-md-4 visible-xs"
              style="margin-bottom: 4.2em;"><?php echo $link_read_more_label; ?></a>
    </div>
  <?php } ?>
  <?php
}

?>
