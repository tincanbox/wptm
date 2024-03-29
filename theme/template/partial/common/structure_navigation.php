<?php

$title = "";
$category = null;
$categories = array();
$post = null;
$post_type = null;

if($main_query->is_single()){
  $posts = $main_query->get_posts();
  if($posts){
    $post = $posts[0];
    $categories = get_the_category($post->ID);
    if($pt = get_post_type($post)){
      if($o = get_post_type_object($pt)){
        $post_type = $o;
      }
    }
  }
}

if($main_query->is_search()){
  $title = __('Search');
}

if ($main_query->is_archive()) {
  $q = $main_query->query;

  if($main_query->is_post_type_archive()){
    $post_type = get_post_type_object($q['post_type']);
  }

  if (@$q['cat']) {
    $ca = get_the_category_by_id($q['cat']);
    $category = get_category_by_slug($ca);
    if ($p = @$category->category_parent) {
      $parent = get_category($p);
      if ($parent) {
        $categories = array($parent);
      }
    }
  }

  if (@$q['category_name']) {
    $cat_l = explode('/', $q['category_name']);
    if (count($cat_l) > 1) {
      $m = array_pop($cat_l);
      $category = get_category_by_slug($m);
      foreach ($cat_l as $cn) {
        $parent = get_category_by_slug($cn);
        $categories[] = $parent;
      }
    } else if (count($cat_l) === 1) {
      $m = $cat_l[0];
      $category = get_category_by_slug($m);
      if ($category->category_parent) {
        $parent = get_category($category->category_parent);
        if ($parent) {
          $categories = array($parent);
        }
      }
    }
  }

  if (@$category->name) {
    $title = $category->name;
  }

  if (@$q['tag']) {
    $t = $q['tag'];
    $title = "#" . $t;
  }
}


?><div>

<ol class="structure-navigation section spacing font-ornament">
  <li>
    <a
      class="link touchable"
      href="<?php bloginfo('url'); ?>"
    ><?php echo __('Home'); ?></a>
  </li>
  <?php

  if($post_type && !in_array($post_type->name, WPTM::$post_type_builtin_target)){
    ?>
    <li>
      <a
        class="link touchable non-builtin-posttype"
        href="<?php echo get_post_type_archive_link($post_type->name); ?>"
        ><?php echo $post_type->labels->name; ?></a>
    </li>
    <?php
  }

  if(@$categories){
    foreach($categories as $c){
      if(!$c) continue;
      if(count($categories) > 1){
        ?>
        <li class="para group">
        <ol>
        <span class="group">[</span>
        <?php
      }
      $category_style_class = 'category-' . $c->slug;
      $category_style_classes = implode(' ', [
        $category_style_class,
        $category_style_class . '-font-color-escape',
        $category_style_class . '-background-color',
      ]);

      $ps = wptm::get_category_parents($c->cat_ID);
      if($ps){
        foreach($ps as $p){
          ?><li class="">
            <?php echo WPTM::template('template/partial/common/category_pill', [
              'label' => $p->name,
              'link' => get_category_link($p->cat_ID),
              'additional_classes' => $category_style_classes
            ]); ?>
          </li>
          <?php
        }
      }
      ?>
      <li>
        <?php echo WPTM::template('template/partial/common/category_pill', [
          'label' => $c->name,
          'link' => get_category_link($c->cat_ID),
          'additional_classes' => $category_style_classes
        ]); ?>
      </li>
      <?php

      if(count($categories) > 1){
        ?>
        <span class="group">]</span>
        </ol>
        </li>
        <?php
      }

    }

  }

  if(@$title){
    ?><li class="active"><?php echo $title; ?></li><?php
  }

?>
</ul>

<?php
// Archive Page
if($main_query->is_archive() && @$category){
  $p = $category;
  if($b = get_categories('child_of='.$p->cat_ID)){
    $cs = array();
    foreach($b as $cb){
      if($category){
        if($category->cat_ID == $cb->cat_ID) continue;
      }
      $cs[] = $cb;
    }
    if(count($cs)){
      ?>
      <div class="section">
        <div style="margin-bottom: .4em;"><?php echo __('related categories'); ?></div>
        <ul class="related-categories">
          <?php foreach($cs as $cb){ ?>
            <li>
              <a
                class="link touchable category-<?php echo $cb->slug; ?>"
                href="<?php echo get_category_link($cb->cat_ID); ?>"
                ><?php echo $cb->name; ?></a>
            </li>
          <?php } ?>
        </ul>
      </div><?php
    }
  }
}
?>

</div>
