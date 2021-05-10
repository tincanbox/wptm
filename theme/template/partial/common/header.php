<?php

global $wp;
$current_url = home_url($wp->request);
$menu_tree = WPTM::get_menu_tree();

?><div id="header" class="fixed-top theme-header-background-color">
  <!-- Fixed navbar -->
  <nav class="site-nav-inner navbar navbar-expand-md">
    <a class="navbar-brand theme-header-font-color animatable attractive" href="/">
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

    <?php WPTM::render('template/partial/common/header_desktop', [
      'current_url' => $current_url,
      'menu_tree' => $menu_tree
    ]); ?>

    <?php WPTM::render('template/partial/common/header_mobile', [
      'current_url' => $current_url,
      'menu_tree' => $menu_tree
    ]); ?>

  </nav>
</div>