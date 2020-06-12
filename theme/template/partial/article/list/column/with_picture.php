<?php

$image_uri = null;
if(has_post_thumbnail()){
  $image_uri = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
}

if(!$image_uri){
  $image_uri = WPTM::option('post_article_list_noimage_url');
}

?>
<article class="article list-type-with-picture <?php echo implode(' ', get_post_class()); ?> col-xs-12 col-sm-6 col-md-4">
  <div class="entry" title="<?php the_title(); ?>">
    <a
      class="feature-image <?php echo !@$image_uri ? 'no-image' : ''; ?>"
      href="<?php the_permalink(); ?>"
      style="<?php echo @$image_uri ? "background-image:url('".$image_uri[0]."');'" : ''; ?>"></a>
    <div
      class="article-list-column-caption">
      <div class="upper">
        <div class="data date"><?php the_time('Y.m.d'); ?></div>
        <?php

        $now = time();
        $time = get_the_time('U');

        if($now - $time < 60 * 60 * 24 * (int)WPTM::option('post_badge_new_interval')){
          ?><div class="badge badge-new" style="">New</div><?php
        }

        ?>
      </div>
      <div class="data title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
      <div class="data category" style="text-align: right;">
      <?php

        $cats = get_the_category($post->ID);
        $arts = WPTM::option('category_for_article_manage');
        $valid = array();
        foreach($arts as $slug => $b){
          if($b){
            $valid[] = $slug;
          }
        }
        foreach($cats as $c){
          if(in_array($c->slug, $valid) || true){
            ?><div class="article-category-pill">
              <a href="<?php echo get_category_link($c->cat_ID); ?>"><?php echo $c->name; ?></a>
            </div><?php
          }
        }
      ?>
      </div>
    </div>
  </div>
</article>
