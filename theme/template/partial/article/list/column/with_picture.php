<?php

setup_postdata($post);

$image_uri = null;
if (has_post_thumbnail()) {
  $image_uri = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
}

if (!$image_uri) {
  $image_uri = array($opt_post_article_list_noimage_url ?: get_bloginfo('template_directory') . "/static/image/noimage.png");
}

$cats = get_the_category($post->ID);
$catc = WPTM::generate_visible_category_list($cats);

?>
<article class="article list-type-with-picture <?php
  if(@count($catc['deprecated_category_list'])){
    ?>deprecated<?php
  }
  ?> <?php echo implode(' ', get_post_class()); ?> col-xs-12 col-sm-6 col-md-4">
  <div class="entry animatable" title="<?php the_title(); ?>">
    <a class="feature-image <?php echo !@$image_uri ? 'no-image' : ''; ?>" href="<?php the_permalink(); ?>" style="<?php echo @$image_uri ? "background-image:url('" . $image_uri[0] . "');" : ''; ?>"></a>
    <div class="article-list-column-caption article-background-color article-font-color-escape">
      <div class="upper">
        <?php if ($opt_post_show_time) { ?>
          <div class="article-font-color-escape data date"><?php the_date(); ?> <?php the_time(); ?></div>
        <?php } ?>
        <?php
        $now = time();
        $time = get_the_time('U');
        if ($now - $time < 60 * 60 * 24 * ((int)$opt_post_badge_new_interval)) {
          ?><div class="badge badge-new" style="">New</div><?php
        }
        ?>
      </div>
      <div class="data title article-font-color-escape">
        <a class="article-font-color-escape" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </div>
      <div class="article-category-pill-box article-font-color-escape inline-block-wrapper data category">
        &nbsp;
        <?php

       foreach ($catc['visible_category_list'] as $c) {
          ?>
          <div class="article-category-pill article-background-color-escape">
            <a class="article-font-color" href="<?php echo get_category_link($c->cat_ID); ?>"><?php echo $c->name; ?></a>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
</article>