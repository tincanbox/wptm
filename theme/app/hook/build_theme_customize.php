<?php

use WPMailSMTP\Admin\Pages\ControlTab;

function set_article_group($panel, $type, $name){
  $kp = $type.'.'.$name;
  $panel
    ->section(ucfirst($type).'.'.$name)
      ->control('checkbox', $kp.'.is_active')
      ->control('checkbox', $kp.'.show_in_home')
      ->control('checkbox', $kp.'.show_eyecatch')
      ->control('checkbox', $kp.'.show_date')
      ->control('checkbox', $kp.'.show_time')
      ->control('text', $kp.'.display_priority')
      ->control('color', $kp.'.theme_background_color')
      ->control('number', $kp.'.theme_background_opacity', ['description' => '0 ~ 255'])
      ->control('color', $kp.'.theme_background_font_color_visibility', [])
      ->control('upload', $kp.'.theme_background_image')
      ->control('select', $kp.'.theme_background_image_size', ['choices' => ['cover' => 'cover', 'repeat' => 'repeat']])
      ->control('image', $kp.'.icon')
      ->control('number', $kp.'.article_count')
      ->control('select', $kp.'.list_type',
          array(
             'choices' => array(
               'default' => 'default',
               'with_picture' => 'with_picture',
               'simple_row' => 'simple_row',
               'minimum' => 'minimum'
              )
          )
        )
      ->control('text', $kp.'.article_count')
      ->control('checkbox', $kp.'.comment_disabled')
      ->control('checkbox', $kp.'.search_excluded')
     ;
}

# Basis
$customizer->UI->build()->panel('basis')
  ->section('info')
    ->control('text', 'basis_owner')
    ->control('number', 'basis_since_year')
  ->section('maintenace')
    ->control('checkbox', 'basis_maintenance')
    ->control('text', 'basis_maintenance_secret_key')
    ->control('text', 'basis_maintenance_secret_value')
  ->section('share')
    ->control('checkbox', 'basis_share_active', [])
    ->control('text', 'facebook_app_id')
  ->section('search')
    ->control('checkbox', 'basis_search_active', [])
  ;

# Font
$customizer->UI->build()->panel('font')
  ->section('main', array('title' => 'Main'))
    ->control('url', 'font_default_name', [])
    ->control('url', 'font_default_url', [])
    ->control('url', 'font_ornament_name', [])
    ->control('url', 'font_ornament_url', [])
  ;

# Appearance
$customizer->UI->build()->panel('appearance')
  ->section('logo', array('title' => 'Logo'))
    ->control('upload', 'logo')
    ->control('number', 'logo_initial_height')
    ->control('upload', 'logo_footer')
  ->section('background')
    ->control('color', 'theme_background_color')
    ->control('number', 'theme_background_opacity')
    ->control('color', 'theme_background_font_color_visibility')
    ->control('upload', 'theme_background_image')
    ->control('select', 'theme_background_image_size')
  ->section('header')
    ->control('color', 'theme_header_background_color')
    ->control('number', 'theme_header_background_initial_opacity')
    ->control('number', 'theme_header_background_stable_opacity')
    ->control('color', 'theme_header_font_color')
  ->section('footer')
    ->control('checkbox', 'footer_show_brand')
    ->control('color', 'theme_footer_background_color')
    ->control('color', 'theme_footer_font_color')
  ->section('section')
    ->control('color', 'section_background_color')
    ->control('number', 'section_background_opacity')
    ->control('color', 'section_font_color')
  ;

# Top
$customizer->UI->build()->panel('top')
  ->section('home')
    ->control('checkbox', 'top_use_template', [], ['default' => false])
    ->control('text', 'top_template_path', [])
    ->control('text', 'top_static_primary_posts', [])
    ->control('text', 'top_static_secondary_posts', [])
  ->section('jumbotron')
    ->control('checkbox', 'jumbotron_active', [])
    ->control('checkbox', 'jumbotron_no_link', [])
    ->control('checkbox', 'jumbotron_as_background_overlay', [], ['default' => false])
    ->control('text', 'jumbotron_post_type')
    ->control('text', 'jumbotron_category')
    ->control('text', 'jumbotron_url_post_meta_key')
    ->control('checkbox', 'jumbotron_caption_stroke')
    ->control('text', 'jumbotron_caption_stroke_width')
    ->control('color', 'jumbotron_caption_stroke_color')
    ->control('number', 'jumbotron_caption_stroke_opacity')
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
    ->control('checkbox', 'post_show_related_article')
    ->control('checkbox', 'post_show_date')
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
  ->section('content')
    ->control('image', 'post_content_caption_ornament')
  ;


foreach (['post_type', 'category', 'tag'] as $name) {
  $matches = $customizer->group($name);
  $panel = $customizer->UI->build()->panel('article_' . $name, array('title' => 'Article: ' . $name));
  foreach($matches as $m){
    switch ($name) {
      case 'post_type':
        $v = $m;
      break;
      case 'category':
      case 'tag':
        $v = $m->slug;
      break;
    }
    set_article_group($panel, $name, $v);
  }
}
