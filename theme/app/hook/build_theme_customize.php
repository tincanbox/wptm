<?php

function set_article_group($panel, $type, $name){
  $kp = $type.'['.$name.']';
  $panel
    ->section(ucfirst($type).'['.$name.']')
      ->control('checkbox', $kp.'[is_active]')
      ->control('checkbox', $kp.'[show_in_home]')
      ->control('text', $kp.'[display_priority]', array('label' => 'Display Priority'))
      ->control('color', $kp.'[theme_background_color]')
      ->control('number', $kp.'[theme_background_opacity]', array(
        'description' => '0 ~ 255'
      ))
      ->control('color', $kp.'[theme_background_font_color_visibility]')
      ->control('upload', $kp.'[theme_background_image]')
      ->control('select', $kp.'[theme_background_image_size]',
        array(
          'choices' => array('cover' => 'cover', 'repeat' => 'repeat')
        ), array(
          'default' => 'cover'
        ))
      ->control('image', $kp.'[icon]')
      ->control('number', $kp.'[article_count]', array('label' => 'TopPage: Article counts'), array('default' => 3))
      ->control('select', $kp.'[list_type]',
          array(
            'label' => 'List Type',
            'choices' => array('default' => 'default', 'with_picture' => 'with_picture', 'simple_row' => 'simple_row')
          ),
          array(
            'default' => 'with_picture'
          )
        )
      ->control('text', $kp.'[article_count]', array('label' => 'TopPage: Article counts'))
      ->control('checkbox', $kp.'[comment_disabled]', array('label' => 'Disable Comment'))
      ->control('checkbox', $kp.'[search_excluded]', array('label' => 'Exclude from search'))
     ;
}

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
    ->control('number', 'theme_background_opacity')
    ->control('color', 'theme_background_font_color_visibility')
    ->control('upload', 'theme_background_image')
    ->control('select', 'theme_background_image_size')
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

# Article
$customizer->UI->build()->panel('article')
  ->section('article basis')
    ->control('checkbox', 'post_show_time')
    ->control('checkbox', 'post_show_tag_list')
    ->control('checkbox', 'post_show_category_list')
    ->control('checkbox', 'post_allow_comment')
  ->section('list')
    ->control('text', 'post_badge_new_interval')
    ->control('image', 'post_article_list_noimage_url')
    ->control('text', 'post_article_list_read_more_label')
  ->section('meta')
    ->control('text', 'post_meta_key_eyecatch_link')
  ;


# posttypes
$ps = get_post_types(array( 'public'   => true, '_builtin' => false));
array_unshift($ps, 'post');
$panel = $customizer->UI->build()->panel('article_post_type', array('title' => 'Article: Post Type'));
foreach($ps as $p){
  set_article_group($panel, 'post_type', $p);
}

# categories
$cats = get_categories();
$panel = $customizer->UI->build()->panel('article_category', array('title' => 'Article: Category'));
foreach($cats as $c){
  set_article_group($panel, 'category', $c->slug);
}

# tags
$tags = get_tags();
$panel = $customizer->UI->build()->panel('article_tag', array('title' => 'Article: Tag'));
foreach ($tags as $t) {
  set_article_group($panel, 'tag', $t->slug);
}