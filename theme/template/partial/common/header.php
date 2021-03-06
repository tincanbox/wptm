<?php

$menu_item_list = wp_get_nav_menu_items("WPTM-DEFAULT");

$config = WPTM::get_article_group_config(array('grouped' => true));

?><div id="header" class="fixed-top">
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md theme-header-background-color">
    <a class="navbar-brand theme-header-font-color animatable attractive" href="/"><?php echo get_bloginfo('title'); ?></a>
    <button class="navbar-toggler collapsed" type="button"
      data-toggle="collapse" data-target="#navbarCollapse"
      aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" >
      <span class="icon-bar top-bar theme-header-background-color-escape"></span>
      <span class="icon-bar middle-bar theme-header-background-color-escape"></span>
      <span class="icon-bar bottom-bar theme-header-background-color-escape"></span>	
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ml-auto">
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
            <a class="nav-link d-flex theme-header-font-color" href="<?php echo $info['url']; ?>">
              <?php if(@$info['icon']){ ?>
                <span
                  class="theme-article-icon center mr-1"
                  style="background-image: url(<?php echo $info['icon']; ?>);"></span>
              <?php } ?>
              <span class="text article-font-color center"><?php echo $info['title']; ?></span>
            </a>
          </li>
          <?php
        }

        ?>

        <li role="separator" class="nav-item dropdown-divider"></li>

      </ul>

      <div class="d-none d-md-block" style="width: 1em;"></div>
      <div class="d-block d-md-none" style="margin-bottom: .6em;"></div>

      <form class="form-inline mb-0" role="search" action="<?php echo home_url('/'); ?>" style="margin-right: 0; margin-left: 0;">
        <div class="form-group w-100">
        <div class="input-group search-box">
          <!--<span class="input-group-addon"><i class="fa fa-user"></i></span>-->
          <input type="text" name="s" class="form-control" placeholder="<?php echo __('Search'); ?>">
          <span class="input-group-append">
            <button type="submit" class="btn btn-default">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
          </span>
        </div>
        </div>
      </form>

    </div>
  </nav>
</div>