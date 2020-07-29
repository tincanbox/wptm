<?php

global $wp_query;
$main_query = $wp_query;

WPTM::render('template/layout', array(
  'yield' => WPTM::template('template/page/article/single', array(
    'main_query' => $main_query
  )),
));
