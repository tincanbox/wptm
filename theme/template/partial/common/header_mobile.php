<nav class="site-nav-inner navbar mobile-only d-md-none">

  <a class="navbar-brand theme-header-font-color animatable attractive" href="<?php echo get_home_url(); ?>">
    <?php if($s = WPTM::option('logo')){ ?>
      <img src="<?php echo $s; ?>">
    <?php } else { ?>
      <?php echo get_bloginfo('title'); ?>
    <?php } ?>
  </a>

  <button class="navbar-toggler collapsed" type="button"
    data-toggle="collapse" data-target="#navbarCollapse"
    aria-controls="navbarCollapse" aria-expanded="false">
    <span class="icon-bar top-bar theme-header-background-color-escape"></span>
    <span class="icon-bar middle-bar theme-header-background-color-escape"></span>
    <span class="icon-bar bottom-bar theme-header-background-color-escape"></span>	
  </button>


  <div class="site-nav-menu collapse navbar-collapse mobile-only" id="navbarCollapse">

    <ul class="navbar-nav ml-auto d-flex d-md-none">
      <?php

      foreach($menu_tree as $info ){

        if(!@$info['is_active']){
          continue;
        }

        $has_children = (count($info['children'])) > 0;

        ?>
        <li
          class="nav-item  <?php
            echo $info['type']; ?>-<?php echo $info['slug'];
          ?> <?php
            echo ($has_children) ? 'dropdown' : ''
          ?> theme-header-font-color animatable"
          >

            <a
              <?php if ($has_children) { ?>
                id="navbarDropdown"
                class="nav-link d-flex theme-header-font-color dropdown-toggle <?php
                  echo ($current_url == $info['url']) ? 'active' : ''
                ?>"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              <?php } else { ?>
                class="nav-link d-flex theme-header-font-color <?php
                  echo ($current_url == $info['url']) ? 'active' : ''
                ?>"
                href="<?php echo $info['url']; ?>"
              <?php } ?>
              >
              <?php if(@$info['icon']){ ?>
                <span
                  class="theme-article-icon center mr-1"
                  style="background-image: url(<?php echo $info['icon']; ?>);"></span>
              <?php } ?>
              <span class="theme-header-font-color center"><?php echo strtoupper($info['title']); ?></span>
            </a>
          
            <?php if ($has_children) { ?>
              <div
                class="site-nav-link-container dropdown-menu"
                aria-labelledby="navbarDropdown">
                <?php foreach ($info['children'] as $child) { ?>
                  <a
                    class="site-nav-link theme-header-font-color center"
                    href="<?php echo $child['url']; ?>"
                    ><?php echo strtoupper($child['title']); ?></a>
                <?php } ?>
              </div>
            <?php } ?>

        </li>

        <?php
      }

      ?>

    </ul>

    <?php if (WPTM::option('basis_search_active')) { ?>
      <hr>
      <ul class="d-block d-md-none navbar-nav">
        <li>
        <form class="d-block d-md-none form mb-0" role="search" action="<?php echo home_url('/'); ?>">
          <div class="form-group w-100">
          <div class="input-group search-box">
            <input type="text" name="s" class="form-control" placeholder="<?php echo __('Search'); ?>">
            <span class="input-group-append">
              <button type="submit" class="btn btn-default">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
            </span>
          </div>
          </div>
        </form>
        </li>
      </ul>

    <?php } ?>

  </div>

</nav>
