<?php

# Brand logo.
$customizer->UI->build()->panel('basis', array('title' => 'Basis'))
  ->section('maintenace', array('title' => 'Maintenance'))
    ->control('checkbox', 'basis_maintenance')
    ->control('text', 'basis_maintenance_secret_key')
    ->control('text', 'basis_maintenance_secret_value')
  ->section('share')
    ->control('text', 'facebook_app_id')
  ;


# Brand logo.
$customizer->UI->build()->panel('appearance', array('title' => 'Appearance'))
  ->section('logo', array('title' => 'Logo'))
    ->control('upload', 'logo')
    ->control('upload', 'logo_footer')
  ->section('background', array('title' => 'Background'))
    ->control('color', 'theme_background_color')
    ->control('color', 'theme_background_font_color_visibility')
    ->control('upload', 'theme_background_image')
    ->control('select', 'theme_background_image_size')
    ->control('text', 'theme_background_image_mask_opacity')
    ->control('text', 'theme_background_image_mask_colorhex')
  ->section('header', array('title' => 'Header'))
    ->control('color', 'theme_header_background_color')
    ->control('color', 'theme_header_font_color')
  ->section('footer', array('title' => 'Footer'))
    ->control('color', 'theme_footer_background_color')
    ->control('color', 'theme_footer_font_color')
  ;

# Top
$customizer->UI->build()->panel('top')
  ->section('jumbotron')
  ->control('text', 'jumbotron_post_type')
  ->control('text', 'jumbotron_category')
  ->control('text', 'jumbotron_url_post_meta_key')
  ;

# Post
$customizer->UI->build()->panel('post')
  ->section('post_basis')
    ->control('checkbox', 'post_show_time')
    ->control('checkbox', 'post_show_category_list')
    ->control('checkbox', 'post_allow_comment')
  ->section('list')
    ->control('text', 'post_badge_new_interval')
    ->control('image', 'post_article_list_noimage_url')
    ->control('text', 'post_article_list_read_more_label')
  ->section('meta')
    ->control('text', 'post_meta_key_eyecatch_link')
  ;

# Sidebanner
$customizer->UI->build()->panel('sidebar', array('title' => 'Side Bar'))
  ->section('basis')
    ->control('checkbox', 'sidebar_toggle')
    ->control('select', 'sidebar_align')
    ->control('text', 'sidebar_post_type')
    ->control('text', 'sidebar_post_meta_key_url')
    ->control('text', 'sidebar_post_meta_key_open_tab')
    ->control('text', 'sidebar_custom_field_banner_url_v')
    ->control('text', 'sidebar_custom_field_banner_url_h')
  ->section('category', array('title' => 'Category'))
    ->control('text', 'sidebar_head_category')
    ->control('text', 'sidebar_menu_category')
  ->section('auto_change', array('title' => 'Auto Change'))
    ->control('text', 'sidebar_head_last_toggle_margin')
    ->control('text', 'sidebar_head_last_increment')
    ->control('text', 'sidebar_head_last_activated_time')
  ;

$cats = get_categories();
$t = array();
$panel = $customizer->UI->build()->panel('category', array('title' => 'Category'));
foreach($cats as $i => $c){
  $t[$c->slug] = $c->name;
  $panel
    ->section('comment disabled', array('title' => 'Comment: Disabled'))
    ->control('checkbox', 'post_comment_disabled_category_list['.$c->slug.']', array('label' => $c->name));

  $panel
    ->section('search exclude', array('title' => 'Category: Excludes From Search'))
    ->control('checkbox', 'category_list_search_excluded['.$c->slug.']', array('label' => $c->name));

  $panel
    ->section('article category', array('title' => 'Category: For Articles'))
    ->control('checkbox', 'category_for_article_manage['.$c->slug.']', array('label' => $c->name));

  $panel
    ->section('menu content categories', array('title' => 'Category: Visible in the Menu'))
    ->control('checkbox', 'category_for_global_menu['.$c->slug.']', array('label' => $c->name));

}

$b = WPTM::option('category_for_article_manage');
if($b){
  $ps = array();
  foreach($b as $c => $f){
    if(!$f) continue;
    $ps[] = $c;
    $c = get_category_by_slug($c);
    if($c){
      $customizer->UI->build()->panel('categories', array('title' => 'Category Theme'))
        ->section('Category: '.$c->slug)
          ->control('color', 'category['.$c->slug.'][theme-color]', array('label' => 'Theme Color'), array('default' => '#eeeeee'))
          ->control('color', 'category['.$c->slug.'][escape-color]', array('label' => 'Escape Color'), array('default' => '#3f3f3f'))
          ->control('image', 'category['.$c->slug.'][icon]')
          ->control('text', 'category['.$c->slug.'][article_count]', array('label' => 'TopPage: Article counts'))
          ->control('text', 'category['.$c->slug.'][display_priority]', array('label' => 'TopPage: Display Priority'))
        ;
    }
  }
}
