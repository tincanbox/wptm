<?php

add_filter('tiny_mce_before_init', 'wptm_filter_tiny_mce_before_init');
function wptm_filter_tiny_mce_before_init($c){
  $c['plugins'] .= ',code';
  $c['valid_elements'] = "*[*]";
  $c['extend_valid_elements'] = "*[*]";
  #$c['body_id'] = 'primary';
  #$c['body_class'] = 'post';
  #$c['force_br_newlines'] = true;
  #$c['force_p_newlines'] = false;
  $c['valid_children'] = '+body[style],+div[div|span],+span[span],+p';
  #$c['verify_html'] = true;
  return $c;
}

add_filter('mce_external_plugins', 'wptm_filter_tiny_mce_external_plugins');
function wptm_filter_tiny_mce_external_plugins($plugins) {
  $d = get_stylesheet_directory_uri().'/asset/script/vendor/tinymce';
  $plugins['code'] = $d.'/plugins/code/plugin.min.js';
  return $plugins;
}

# Shows more buttons in mce editor.
add_filter("mce_buttons", "wptm_filter_mce_buttons_enable_more_buttons");
function wptm_filter_mce_buttons_enable_more_buttons($buttons) {
  return $buttons;
}

add_filter("mce_buttons_1", "wptm_filter_mce_buttons_1_enable_more_buttons");
function wptm_filter_mce_buttons_1_enable_more_buttons($buttons) {
  return $buttons;
}

add_filter("mce_buttons_2", "wptm_filter_mce_buttons_2_enable_more_buttons");
function wptm_filter_mce_buttons_2_enable_more_buttons($buttons) {
  array_splice($buttons, array_search('forecolor', $buttons) + 1, 0, array('backcolor'));
  return $buttons;
}

add_filter("mce_buttons_3", "wptm_filter_mce_buttons_3_enable_more_buttons");
function wptm_filter_mce_buttons_3_enable_more_buttons($buttons) {
  $buttons[] = 'fontselect';
  $buttons[] = 'fontsizeselect';
  $buttons[] = 'styleselect';
  $buttons[] = 'code';
  #$buttons[] = 'backcolor';
  #$buttons[] = 'cut';
  #$buttons[] = 'copy';
  #$buttons[] = 'paste';
  #$buttons[] = 'charmap';
  #$buttons[] = 'visualaid';
  #$buttons[] = 'newdocument';
  return $buttons;
}


