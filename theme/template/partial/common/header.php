<div id="header">
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md fixed-top wptm-header-background-color">
    <a class="navbar-brand wptm-header-font-color" href="/"><?php echo get_bloginfo('title'); ?></a>
    <button class="navbar-toggler collapsed" type="button"
      data-toggle="collapse" data-target="#navbarCollapse"
      aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" >
      <span class="icon-bar top-bar wptm-header-background-color-escape"></span>
      <span class="icon-bar middle-bar wptm-header-background-color-escape"></span>
      <span class="icon-bar bottom-bar wptm-header-background-color-escape"></span>	
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ml-auto">
        <?php

        $allslug = array();

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
              $d[$p][$slug] = array_merge(array('slug' => $slug), $c);
            }
          }

          ksort($d);

          foreach($d as $priority => $g){
            foreach($g as $cat){
              $c = get_category_by_slug($cat['slug']);
              if($c){
                ?><li class="nav-item category-<?php echo $c->slug; ?>">
                 <a class="nav-link" href="<?php echo get_category_link($c->cat_ID); ?>">
                    <?php if(@$cat['icon']){ ?>
                      <span class="wptm-category-icon" style="background-image: url(<?php echo $cat['icon']; ?>);"></span>
                    <?php } ?>
                    <span class="text category-font-color"><?php echo $c->name; ?></span>
                  </a>
                </li><?php

                $allslug[] = $cat['slug'];
              }
            }
          }

        }
        ?>
        <?php
        $ms = WPTM::option('category_for_global_menu');
        if(@count($ms)){

          $cats = array();
          foreach($ms as $slug => $b){
            if($b && !in_array($slug, $allslug)){
              $cats[] = $slug;
            }
          }

          if($cats){
            ?>
            <li role="separator" class="nav-item dropdown-divider"></li>
            <?php

            foreach($cats as $c){
              $c = get_category_by_slug($c);
              if($c){
                ?><li class="nav-item category-<?php echo $c->slug; ?>">
                  <a class="nav-link" href="<?php echo get_category_link($c->cat_ID); ?>">
                    <span class="text wptm-header-font-color"><?php echo $c->name; ?></span></a>
                </li><?php
              }
            }

          }
          ?>
        <?php } ?>

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