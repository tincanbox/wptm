<?php

global $wp_query;
$main_query = $wp_query;

WPTM::render('template/layout', array(
  'hide_structure_navigation' => true,
  'yield'
    => (WPTM::option('top_use_template'))
     ? WPTM::template('template/' . WPTM::option('top_template_path'))
     : WPTM::template('template/page/home'),
  'main_query' => $main_query
));
