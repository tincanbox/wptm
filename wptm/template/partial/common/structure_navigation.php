<?php

#$main_query = $this->wp_global('wp_query');

?><div>

<ul class="structure-navigation breadcrumb section">

  <li class=""><a class="" href="<?php bloginfo('url'); ?>">HOME</a></li>
  <?php

  if($main_query->is_single()){
    $post = $main_query->get_posts();
    if($post){
      $post = $post[0];
      $pt_s = get_post_type($post);
      $categories = get_the_category($post->ID);
      $title = $post->post_title;

      if($pt_s != 'post' && $pt_s != 'page'){
        $post_type = get_post_type_object($pt_s);
        ?><li><a href="<?php echo get_post_type_archive_link($post_type->name); ?>"><?php echo $post_type->labels->name; ?></a></li>
        <?php
      }
    }
  }

  if($main_query->is_search()){
    $title = __('Search');
  }

  if($main_query->is_archive()){
    $q = $main_query->query;
    if(@$q['category_name']){
      $cat_l = explode('/', $q['category_name']);
      if(count($cat_l) > 1){
        $m = array_pop($cat_l);
        $p = array_pop($cat_l);
        $category = get_category_by_slug($m);
        $parent = get_category_by_slug($p);
        $title = $category->name;
        $categories = array($parent);
      }else if(count($cat_l) === 1){
        $m = $cat_l[0];
        $category = get_category_by_slug($m);
        $title = $category->name;
        if($category->category_parent){
          $parent = get_category($category->category_parent);
          if($parent){
            $categories = array($parent);
          }
        }
      }
    }

    if(@$q['tag']){
      $t = $q['tag'];
      $title = $t;
    }
  }

  if(@$categories){
    foreach($categories as $c){
      if(!$c) continue;
      $ps = WPTM::get_category_parents($c->cat_ID);
      if($ps){
        foreach($ps as $p){
          ?><li>
            <a href="<?php echo get_category_link($p->cat_ID); ?>"><?php echo $p->name; ?></a>
          </li>
          <?php
        }
      }
      ?><li>
        <a href="<?php echo get_category_link($c->cat_ID); ?>"><?php echo $c->name; ?></a>
      </li>
      <?php
    }

  }

  if(@$title){
    ?><li class="active"><?php echo $title; ?></li><?php
  }

?>
</ul>

<?php
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
        <div style="margin-bottom: .4em;">関連カテゴリー</div>
        <ul class="related-categories"><?php
        foreach($cs as $cb){
          ?><li><a href="<?php echo get_category_link($cb->cat_ID); ?>"><?php echo $cb->name; ?></a></li><?php
        }
        ?>
        </ul>
      </div><?php
    }
  }
}
?>

</div>
