<?php

# Brand logo.
$customizer->UI->build()->panel('appearance', array('title' => '外観'))
  ->section('logo', array('title' => 'ロゴ'))
    ->control('upload', 'logo')
    ->control('upload', 'logo_footer')
  ->section('background', array('title' => '背景'))
    ->control('color', 'theme_background_color')
    ->control('color', 'theme_background_font_color_visibility')
    ->control('upload', 'theme_background_image')
    ->control('select', 'theme_background_image_size')
    ->control('text', 'theme_background_image_mask_opacity')
    ->control('text', 'theme_background_image_mask_colorhex')
  ->section('footer', array('title' => 'フッター'))
    ->control('color', 'theme_footer_background_color')
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
  ->section('list')
    ->control('text', 'post_badge_new_interval')
    ->control('image', 'post_article_list_noimage_url')
    ->control('text', 'post_article_list_read_more_label')
  ->section('meta')
    ->control('text', 'post_meta_key_eyecatch_link')
  ;

# Sidebanner
$customizer->UI->build()->panel('sidebar', array('title' => 'サイドバー'))
  ->section('basis')
  ->control('checkbox', 'sidebar_toggle')
  ->control('text', 'sidebar_post_type')
  ->control('text', 'sidebar_post_meta_key_url')
  ->control('text', 'sidebar_post_meta_key_open_tab')
  ->control('text', 'sidebar_custom_field_banner_url_v')
  ->control('text', 'sidebar_custom_field_banner_url_h')
  ->control('text', 'sidebar_head_category')
  ->control('text', 'sidebar_menu_category')
  ->control('text', 'sidebar_head_last_toggle_margin')
  ->control('text', 'sidebar_head_last_increment')
  ->control('text', 'sidebar_head_last_activated_time')
  ;

$cats = get_categories();
$t = array();
$panel = $customizer->UI->build()->panel('category', array('title' => 'カテゴリー'));
foreach($cats as $i => $c){
  $t[$c->slug] = $c->name;
  $panel
    ->section('comment disabled', array('title' => 'コメント機能無効化'))
    ->control('checkbox', 'post_comment_disabled_category_list['.$c->slug.']', array('label' => $c->name));

  $panel
    ->section('search exclude', array('title' => '検索除外カテゴリー'))
    ->control('checkbox', 'category_list_search_excluded['.$c->slug.']', array('label' => $c->name));

  $panel
    ->section('article category', array('title' => '記事用カテゴリー選択'))
    ->control('checkbox', 'category_for_article_manage['.$c->slug.']', array('label' => $c->name));

  $panel
    ->section('menu content categories', array('title' => 'メニュー表示カテゴリー'))
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
      $customizer->UI->build()->panel('categories', array('title' => '記事用カテゴリー'))
        ->section('Category: '.$c->slug)
        ->control('text', 'category['.$c->slug.'][article_count]', array('label' => 'トップ記事数'))
        ->control('text', 'category['.$c->slug.'][display_priority]', array('label' => 'トップ表示順'))
        ;
    }
  }
}
