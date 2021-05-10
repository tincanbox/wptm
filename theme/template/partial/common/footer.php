<?php

$menu_tree = WPTM::get_menu_tree();

?><div id="footer" class="theme-footer-background-color invisible-onload">

  <div class="container">
  <div class="row mb-4">
  <?php

  foreach($menu_tree as $info ){

    if(!@$info['is_active']){
      continue;
    }

    $has_children = (count($info['children'])) > 0;

    ?>
    <div class="col-md-3 theme-footer-font-color">

      <p class="caption <?php
          echo $info['type']; ?>-<?php echo $info['slug'];
        ?>"
        >
        <?php if (strlen($info['url'])) { ?>
          <a
        <?php } else { ?>
          <span
        <?php } ?>
            class="link d-flex theme-footer-font-color <?php
            if ($has_children) {
              echo ($current_url == $info['url']) ? 'active' : '';
            }
            ?>"
            href="<?php echo $info['url']; ?>"
            >
            <?php if(@$info['icon']){ ?>
              <span
                class="theme-article-icon center mr-1"
                style="background-image: url(<?php echo $info['icon']; ?>);"></span>
            <?php } ?>
            <span class="theme-footer-font-color center"><?php echo $info['title']; ?></span>
        <?php if (strlen($info['url'])) { ?>
          </a>
        <?php } else { ?>
          </span>
        <?php } ?>
      </p>
      
      <?php if ($has_children) { ?>
        <ul class="">
            <?php foreach ($info['children'] as $child) { ?>
              <li class="nav-item <?php
                echo $info['type']; ?>-<?php echo $info['slug'];
                ?> animatable">

                <a
                  class="link theme-footer-font-color"
                  href="<?php echo $child['url']; ?>">
                  <span class="text center"><?php echo $child['title']; ?></span>
                </a>
              </li>
            <?php } ?>
        </ul>
      <?php } // END IF ?>
    </li>

    </div>
    <?php } // END FOREACH ?>
  </div>

  <div class="row">

    <div class="col-xs-12 col-md-6" style="clear: both; overflow: hidden;">
      <?php if(WPTM::option('basis_share_active')){ ?>
        <?php WPTM::render('template/partial/common/share/bootstrap_footer'); ?>
      <?php } ?>
    </div>

    <div class="col-xs-12 col-md-6 text-right">
      <div class="mb-2">
        <?php if($s = WPTM::option('logo_footer')){ ?>
          <img src="<?php echo $s; ?>" style="width: 180px;"/>
        <?php }else{ ?>
          <span class="site-title theme-footer-font-color"><?php echo get_bloginfo('title'); ?></span>
        <?php } ?>
      </div>
    </div>
    <div class="col-12 text-right">
      <div class="theme-footer-font-color copyright">
        <?php
        $current = new DateTime();
        $current_year = $current->format('Y');
        $since_year = @WPTM::option('basis_since_year') ?: $current_year;
        ?>
        &copy;
        <?php echo $since_year; ?><?php ($since_year != $current_year) ? ' - ' . $current_year : '' ; ?>
        <?php echo @WPTM::option('basis_owner') ?: get_bloginfo('title'); ?> All rights reserved.
      </div>
    </div>

  </div>

</div>
</div>