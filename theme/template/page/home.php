<?php

// Shows HOME static page.
$post = get_page_by_path('home');
if($post){
  echo apply_filters('the_content', get_post_field('post_content', $post_id));
}

?>
<div class="container">
<?php 

$link_read_more_label = ($v = WPTM::option('post_article_list_read_more_label')) ? $v : 'More &raquo;';

$priority = array();
$cat_c = WPTM::option('category');

$article_group = WPTM::get_article_group_config(array('ordered' => true));

?>
<div class="mb-5">
  <?php

  WPTM::render('template/partial/article/list/group_default', array(
    'list_type' => 'with_picture',
    'query' => array(
      'post_type' => 'dog',
      'posts_per_page' => (int)@$s['article_count'] ?: 6
    )
  ));

  ?>
  <div class="mt-3 mb-5">
    <a
      href="<?php echo get_post_type_archive_link('dog'); ?>"
      style="margin: auto; display: block; text-align: center; width: 66%; min-width: 320px; color: #fff; background: #99ccf7; padding: 1rem; margin-top: 1.5rem; border-radius: .6rem; font-size: 1.2rem;" >もっと見る</a>
  </div>
</div>

<div class="mb-5">&nbsp;</div>


<?php

foreach($article_group as $pri => $step){

  foreach($step as $c){
    if(!@$c['show_in_home']){
      continue;
    }
    $o = $c['object'];
    ?>
    <?php if($o){ ?>
      <div class="<?php echo $c['type']; ?>-<?php echo $c['slug']; ?> mb-5">
        <div class="article-list-group-caption-wrap row mt-1 mb-4">
          <h3 class="article-list-group-caption theme-font-color-escape col-10 col-md-11 mb-0 rack-board">
            <?php if(@$c['icon']){ ?>
              <i class="theme-article-icon mr-1" style="background-image: url(<?php echo $c['icon']; ?>);"></i>
            <?php } ?>
            <span class="mr-3"><?php echo $c['name']; ?></span>
            <a
              class="theme-font-color-escape animatable attractive d-inline-block"
              href="<?php echo $c['link']; ?>">
              <div class="theme-font-color-escape" style="width:1em; height:1em; transform:rotate(90deg);">
                <svg id="svg" viewBox="0 0 512 512"><use xlink:href="#chevron-up"></use></svg>
              </div>
            </a>

          </h3>
        </div>
        <?php
        WPTM::render('template/partial/article/list/group_default', array(
          'list_type' => 'with_picture',
          'target_article_group' => array($c),
          'query' => array(
            'posts_per_page' => (int)@$s['article_count'] ?: 6
          )
        ));
        ?>
        <div class="text-right">
          <a
            href="<?php echo $c['link']; ?>"
            class="theme-font-color-escape d-block mt-2"
            style="margin-bottom: 4.2em;"><?php echo __($link_read_more_label); ?> <?php echo $c['name']; ?></a>
        </div>
      </div>
    <?php } ?>
    <?php
  }
}

?>
</div>