<?php

global $wp_query;
$main_query = $wp_query;

WPTM::render('template/layout',
  (WPTM::option('top_use_template'))
    ? [
      'hide_structure_navigation' => true,
      'main_query' => $main_query,
      'use_empty_layout' => true,
      'yield' => WPTM::template('template/' . WPTM::option('top_template_path')),
    ]
    : [
      'hide_structure_navigation' => true,
      'main_query' => $main_query,
      'yield' => WPTM::template('template/page/home'),
  ]
);
