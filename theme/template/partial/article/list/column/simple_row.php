<?php
$image_uri = null;
if (has_post_thumbnail()) {
  $image_uri = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
}
if (!$image_uri) {
  $image_uri = array(@$opt_post_article_list_noimage_url ?: get_bloginfo('template_directory') . "/static/image/noimage.png");
}
?>
<div class="list-group-item theme-font-color col-12 pl-0 pt-2 pr-2 pb-2 <?php echo implode(' ', get_post_class()); ?>">
    <div class="list-group-item-text">
     <div class="media row p-0 m-0">
        <div
          class="media-left media-middle col-12 col-sm-3 col-md-2 col-lg-2 d-block p-0 pl-2">
          <a class="" href="<?php the_permalink(); ?>">
            <div class="feature-image" style="background-image:url(<?php echo @$image_uri[0]; ?>)"></div>
          </a>
        </div>
        <div class="article-list-group-content-box col-12 col-sm-9 col-md-10 col-lg-10 pl-2">
          <div class="d-block d-md-none pt-2">&nbsp;</div>
          <div>
            <a href="<?php the_permalink(); ?>">
            <h4 class="meadia-heading list-group-item-heading">
              <span><?php the_title(); ?></span>
            </h4>
            <?php if($opt_post_show_time){ ?>
              <div>
                <span class="text-muted"><?php the_date(); ?> <?php the_time(); ?></span>
              </div>
            <?php } ?>
            <p><?php
              echo substr( wp_strip_all_tags(get_the_content()) , 0 , 120 );
            ?></p>
            </a>
          </div>
          <div class="article-category-pill-box">
            <?php

            $cats = get_the_category();
            $cnfs = WPTM::option('category');
            $valid = array();
            foreach ($cnfs as $slug => $b) {
              if (@$b['is_active']) {
                $valid[] = $slug;
              }
            }
            foreach ($cats as $c) {
              if (in_array($c->slug, $valid) || true) {
              ?>
                <div class="article-category-pill">
                  <a
                    class=""
                    href="<?php echo get_category_link($c->cat_ID); ?>"><?php echo $c->name; ?></a>
                </div>
              <?php
              }
            }
            ?>
          </div>

        </div>
      </div>
    </div>
  </a>
</div>
