<?php

global $wp_query;
$main_query = $wp_query;

WPTM::render('template/layout', array(
  'main_query' => $main_query,
  'hide_structure_navigation' => 1,
  'yield' => WPTM::template('template/page/error/404')
));
