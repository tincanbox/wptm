<?php

?>

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
            <span class="theme-header-font-color center"><?php echo $info['title']; ?></span>
          </a>
        
          <?php if ($has_children) { ?>
            <div
              class="site-nav-link-container dropdown-menu"
              aria-labelledby="navbarDropdown">
              <?php foreach ($info['children'] as $child) { ?>
                <a
                  class="site-nav-link theme-header-font-color center"
                  href="<?php echo $child['url']; ?>"
                  ><?php echo $child['title']; ?></a>
              <?php } ?>
            </div>
          <?php } ?>

      </li>

      <?php
    }

    ?>

    <?php if (WPTM::option('basis_contact_active')) { ?>
      <li
        class="nav-item theme-header-font-color animatable">
        <a
          class="nav-link d-flex theme-header-font-color"
          href="<?php echo home_url('/'); ?>contact"
          >
          <?php if($icon = @WPTM::option('basis_contact_icon')){ ?>
            <span
              class="theme-article-icon center mr-1"
              style="background-image: url(<?php echo $icon; ?>);"></span>
          <?php } ?>
          <span class="theme-header-font-color center"><?php echo __('Contact'); ?></span>
        </a>
      </li>
    <?php } ?>

  </ul>

  <?php if (WPTM::option('basis_search_active')) { ?>
    <ul class="d-block d-md-none navbar-nav">
      <li role="separator" class="nav-item dropdown-divider"></li>
    </ul>

    <div class="d-block d-md-none" style="padding-bottom: .6em;"></div>

    <form class="d-block d-md-none form mb-0" role="search" action="<?php echo home_url('/'); ?>" style="margin-right: 0; margin-left: 0;">
      <div class="form-group w-100">
      <div class="input-group search-box">
        <input type="text" name="s" class="form-control" placeholder="<?php echo __('Search'); ?>">
        <span class="input-group-append">
          <button type="submit" class="btn btn-default">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
        </span>
      </div>
      </div>
    </form>

  <?php } ?>

</div>
