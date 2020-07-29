<div id="header" class="fixed-top">
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

        $article_group = WPTM::get_article_group_config();

        foreach($article_group as $priority => $g){
          foreach($g as $c){
            $slug = $c['slug'];
            ?>
            <li class="nav-item <?php echo $c['prefix']; ?>-<?php echo $c['slug']; ?> animatable">
              <?php

              if(!@$c['is_active']){
                continue;
              }

              $url = false; $name = false;
              switch($c['type']){
                case 'category':
                  $cat = get_category_by_slug($slug);
                  $url = get_category_link($cat->cat_ID);
                  $name = $cat->name;
                break;
                case 'posttype':
                  $url = get_post_type_archive_link($slug);
                  $name = ucfirst($slug);
                break;
              }
              if(!$url) continue;
              if(!$name) continue;

              ?>
              <a class="nav-link d-flex" href="<?php echo $url; ?>">
                <?php if(@$c['icon']){ ?>
                  <span
                    class="theme-article-icon center mr-1"
                    style="background-image: url(<?php echo $c['icon']; ?>);"></span>
                <?php } ?>
                <span class="text article-font-color center"><?php echo $name; ?></span>
              </a>
            </li>
            <?php
          }
        }

        ?>

        <li role="separator" class="nav-item dropdown-divider"></li>

        <?php 
        $m = wp_get_nav_menu_items("default");
        ?>
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