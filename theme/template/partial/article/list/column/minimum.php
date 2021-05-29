<?

$post_type = $post->post_type;
$post_type_option = WPTM::option('post_type.' . $post_type);


?><div class="section col-12 p-3 mb-2 list-type-minimum <?php echo implode(' ', get_post_class()); ?>">
    <div class="list-group-item-text">
     <div class="p-0 m-0">
        <div class="article-list-group-content-box col-12 col-sm-9 col-md-10 col-lg-10 pl-2">
          <div>
            <a class="link" href="<?php the_permalink(); ?>">
              <?php
              $datetime = '';
              if($opt_post_show_date && @$post_type_option['show_date']){
                $datetime .= get_the_date(null, $post);
              }
              if($opt_post_show_date && @$post_type_option['show_date']){
                $datetime .= ' ' . get_the_time(null, $post);
              }

              if ($datetime) {
                ?>
                <span class="post-datetime">
                  <?php if($opt_post_show_date && @$post_type_option['show_date']){ ?>
                    <span class="post-date font-ornament"><?php the_date(); ?> </span>
                  <?php } ?>
                  <?php if($opt_post_show_time && @$post_type_option['show_time']){ ?>
                    <span class="post-time font-ornament"><?php the_time(); ?> </span>
                  <?php } ?>
                </span>
                <?php
              }
              ?>
              <span class="media-heading list-group-item-heading">
                <?php the_title(); ?>
              </span>
            </a>
          </div>
          <?php

          $cnfs = WPTM::option('category');

          if ($cnfs) {
            ?>
            <div class="article-category-pill-box">
            <?php

              $valid = array();
              $cats = get_the_category();

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
          <?php

          }  // END IF

          ?>

        </div>
      </div>
    </div>
  </a>
</div>
