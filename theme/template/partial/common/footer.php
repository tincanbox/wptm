<div id="footer" class="theme-footer-background-color invisible-onload">

  <div class="container">
  <div class="row mb-4">

    <div class="col-md-4 theme-footer-font-color">
      <p class="caption"><?php echo __('Contents') ?></p>
      <ul class="">
      <?php

      $cats = WPTM::option('category_for_article_manage');
      $conf = WPTM::option('category');

      if($cats){
        $d = array();
        foreach($cats as $slug => $b){
          if($b && isset($conf[$slug])){
            $c = $conf[$slug];
            $p = (int)$c['display_priority'];
            if(!@$d[$p]){
              $d[$p] = array();
            }
            $d[$p][] = array_merge(array('slug' => $slug), $c);
          }
        }

        ksort($d);

        foreach($d as $priority => $g){
          foreach($g as $cat){
            $c = get_category_by_slug($cat['slug']);
            if($c){
              ?>
              <li class="category-<?php echo $c->slug; ?>">
                <a
                  class="link theme-footer-font-color"
                  href="<?php echo get_category_link($c->cat_ID); ?>"><?php echo $c->name; ?></a>
              </li>
              <?php
            }
          }
        }
      }

      ?>
      </ul>
    </div>

    <div class="col-md-4 theme-footer-font-color">
      <p class="caption">Section 02</p>
      <ul>
        <li><a class="link theme-footer-font-color" href="" >Sample</a></li>
      </ul>
    </div>

    <div class="col-md-4 theme-footer-font-color">
      <p class="caption">Section 3</p>
      <ul>
        <li><a class="link theme-footer-font-color" href="">Sample</a></li>
      </ul>
    </div>

  </div>
  <div class="row">

    <div class="col-xs-12 col-md-6" style="clear: both; overflow: hidden;">
    <?php WPTM::render('template/partial/common/share/bootstrap_footer'); ?>
    </div>

    <div class="col-xs-12 col-md-6" style="text-align: right;">
      <div class="mb-2">
        <?php if($s = WPTM::option('logo_footer')){ ?>
          <img src="<?php echo $s; ?>" style="width: 180px;"/>
        <?php }else{ ?>
          <span class="site-title theme-footer-font-color"><?php echo get_bloginfo('title'); ?></span>
        <?php } ?>
      </div>
      <div class="theme-footer-font-color copyright">
        &copy; 2020 YOURCOOLCOMPANY All rights reserved.
      </div>
    </div>

  </div>

</div>
</div>