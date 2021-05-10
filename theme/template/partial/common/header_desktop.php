<?php

?>

<div class="site-nav-menu collapse navbar-collapse desktop-only">

  <ul class="navbar-nav ml-auto d-flex">
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

        <?php if (strlen($info['url'])) { ?>
          <a
        <?php } else { ?>
          <span
        <?php } ?>
            class="nav-link d-flex theme-header-font-color <?php
              echo ($has_children) ? 'dropdown-toggle' : '';
            ?> <?php
              echo ($current_url == $info['url']) ? 'active' : ''
            ?>"
            role="button"
            href="<?php echo $info['url']; ?>"
            >
            <?php if(@$info['icon']){ ?>
              <span
                class="theme-article-icon center mr-1"
                style="background-image: url(<?php echo $info['icon']; ?>);"></span>
            <?php } ?>
            <span class="theme-header-font-color center site-nav-interactive"><?php echo $info['title']; ?></span>
        <?php if (strlen($info['url'])) { ?>
          </a>
        <?php } else { ?>
          </span>
        <?php } ?>
        
          <?php if ($has_children) { ?>
            <div
              class="site-nav-link-container dropdown-menu theme-header-background-color"
              >
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
          class="site-nav-link nav-link d-flex theme-header-font-color center"
          href="<?php echo home_url('/'); ?>contact"
          >
          <?php if($icon = @WPTM::option('basis_contact_icon')){ ?>
            <span
              class="theme-article-icon center mr-1"
              style="background-image: url(<?php echo $icon; ?>);"></span>
          <?php } ?>
          <span class="site-nav-interactive theme-header-font-color center"><?php echo __('Contact'); ?></span>
        </a>
      </li>
    <?php } ?>

  </ul>

  <?php if (WPTM::option('basis_search_active')) { ?>

    <div class="d-none d-md-block" style="width: 1em;"></div>
    <form class="d-none d-md-inline form-inline mb-0" role="search" action="<?php echo home_url('/'); ?>" style="margin-right: 0; margin-left: 0;">
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
