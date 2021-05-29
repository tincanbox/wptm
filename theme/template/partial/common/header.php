<?php

global $wp;
$current_url = home_url($wp->request);
$menu_tree = WPTM::get_menu_tree();

?><div id="header" class="fixed-top theme-header-background-color font-ornament wait-humble">
  <!-- Fixed navbar -->
  <?php WPTM::render('template/partial/common/header_desktop', [
    'current_url' => $current_url,
    'menu_tree' => $menu_tree
  ]); ?>

  <?php WPTM::render('template/partial/common/header_mobile', [
    'current_url' => $current_url,
    'menu_tree' => $menu_tree
  ]); ?>

</div>