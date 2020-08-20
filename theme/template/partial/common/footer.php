<?php

$menu_item_list = wp_get_nav_menu_items("WPTM-DEFAULT");
$config = WPTM::get_article_group_config(array('grouped' => true));

?><div id="footer" class="theme-footer-background-color invisible-onload">

  <div class="container">
  <div class="row mb-4">

    <div class="col-md-4 theme-footer-font-color">
      <p class="caption"><?php echo __('コンテンツ') ?></p>
      <?php

      foreach($menu_item_list as $menu ){
        $info = array(
          'is_active' => true,
          'title' => $menu->title,
          'type' => $menu->type,
          'url' => $menu->url,
          'slug' => null
        );
        $info['title'] = $menu->title;
        $override = array();

        switch($menu->type){
          case "taxonomy":
            $term = get_term_by("id", $menu->object_id, $menu->object);
            if(!$term) continue 2;
            switch($menu->object){
              case "category":
              case "tag":
              if($c = @$config[$menu->object][$term->slug]){
                $override = $c;
              }
              break;
            }
            $override['slug'] = $term->slug;
            $override['type'] = $menu->object;
          break;
          case "post_type":
            if($c = @$config['post_type'][$menu->object]){
              $override = $c;
            }
            $override['slug'] = $menu->object;
          break;
          default:
            $override['slug'] = $menu->object;
          break;
        }

        if(count($override)){
          $info = array_merge($info, $override);
        }

        ?>
        <li class="nav-item <?php
          echo $info['type']; ?>-<?php echo $info['slug'];
          ?> animatable">
          <?php

          if(!@$info['is_active']){
            continue;
          }

          ?>
          <a class="link theme-footer-font-color" href="<?php echo $info['url']; ?>">
            <span class="text center"><?php echo $info['title']; ?></span>
          </a>
        </li>
        <?php
      }

      ?>
      </ul>
    </div>

    <div class="col-md-4 theme-footer-font-color">
      <p class="caption">&nbsp;</p>
      <ul>
        <li><a class="link theme-footer-font-color" href="<?php echo get_permalink(get_page_by_path('access')) ?>" >店舗情報</a></li>
        <li><a class="link theme-footer-font-color" href="<?php echo get_permalink(get_page_by_path('company')) ?>" >会社概要</a></li>
        <li><a class="link theme-footer-font-color" href="<?php echo get_permalink(get_page_by_path('privacy-policy')) ?>" >プライバシーポリシー</a></li>
      </ul>
    </div>

  </div>
  <div class="row">

    <div class="col-xs-12 col-md-6 mb-4" style="clear: both; overflow: hidden;">
      <?php WPTM::render('template/partial/common/share/bootstrap_footer'); ?>
    </div>

    <div class="col-xs-12 col-md-6" style="text-align: right;">
      <div class="mb-3">
        <div class="nabvar-nav nav-left ml-2">
          <a target="blank" class="nav-item nav-type-sns nav-sns-instagram" href="https://www.instagram.com/joyland.pet/">&nbsp;</a>
          <a target="blank" class="nav-item nav-type-sns nav-sns-facebook" href="https://www.facebook.com/%E3%83%9A%E3%83%83%E3%83%88%E3%82%B7%E3%83%A7%E3%83%83%E3%83%97joyland-120001406450991">&nbsp;</a>
          <a target="blank" class="nav-item nav-type-sns nav-sns-twitter" href="https://twitter.com/joyland9">&nbsp;</a>
        </div>
      </div>
      <div class="mb-2">
        <?php if($s = WPTM::option('logo_footer')){ ?>
          <img src="<?php echo $s; ?>" style="width: 180px;"/>
        <?php }else{ ?>
          <span class="site-title theme-footer-font-color">JOYLAND inc.</span>
        <?php } ?>
      </div>
      <div class="theme-footer-font-color copyright">
        &copy; 2020 JOYLAND inc. All rights reserved.
      </div>
    </div>

  </div>

</div>
</div>