<?php

global $wp_query;
$main_query = $wp_query;

WPTM::render('template/layout', array(
  'yield' => WPTM::template('template/page/search', array(
    'main_query' => $main_query
  )),
));
