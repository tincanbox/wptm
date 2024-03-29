<?php

# - default:
#     A default value for the setting if none is defined
# - type:
#     Optional. Specifies the TYPE of setting this is. Options are 'option' or 'theme_mod' (defaults to 'theme_mod')
# - capability:
#     Optional. You can define a capability a user must have to modify this setting. Default if not specified: edit_theme_options
# - theme_supports:
#     Optional. This can be used to hide a setting if the theme lacks support for a specific feature (using add_theme_support).
# - transport:
#     Optional. This can be either 'refresh' (default) or 'postMessage'.
#     Only set this to 'postMessage' if you are writing custom Javascript to control the Theme Customizer's live preview.
# - sanitize_callback:
#     Optional. A function name to call for sanitizing the input value for this setting.
#     The function should be of the form of a standard filter function, where it accepts the input data and returns the sanitized data.
# - sanitize_js_callback:
#     Optional. A function name to call for sanitizing the value for this setting for the purposes of outputting to javascript code.
#     The function should be of the form of a standard filter function, where it accepts the input data and returns the sanitized data.
#     This is only necessary if the data to be sent to the customizer window has a special form.
# 
return array(

  # Default options for add_setting()
  # 'sample' => array(
  #   # Default options for WP_Customize_Control::add_control()
  #   'control' => array()
  # ),

  '__group' => [
    'is_active' => [
      'default' => true
    ],
    'show_in_home' => [
      'default' => true
    ],
    'show_eyecatch' => [
      'default' => true
    ],
    'show_related_article' => [
      'default' => true
    ],
    'show_date' => [
      'default' => true
    ],
    'show_time' => [
      'default' => true
    ],
    'display_priority' => [
      'default' => 0
    ],
    'theme_background_color' => [
      'default' => ''
    ],
    'theme_background_opacity' => [
      'default' => 144,
      'control' => [
        'description' => '0 ~ 255'
      ]
    ],
    'theme_background_font_color_visibility' => [
      'default' => '#2f2f2f'
    ],
    'theme_background_image' => [
      'default' => ''
    ],
    'theme_background_image_size' => [
      'default' => 'cover',
      'choices' => ['cover' => 'cover', 'repeat' => 'repeat']
    ],
    'icon' => [
      'default' => ''
    ],
    'article_count' => [
      'default' => 8
    ],
    'list_type' => [
      'default' => 'with_picture',
      'choices' => array(
        'default' => 'default',
        'with_picture' => 'with_picture',
        'simple_row' => 'simple_row',
        'minimum' => 'minimum'
      )
    ],
    'comment_disabled' => [
      'default' => true
    ],
    'search_excluded' => [
      'default' => false
    ],
  ],

  /**
   * Basis
   */
  'basis_search_active' => [
    'default' => true
  ],

  /**
   * 
   */
  'top_use_template' => [
    'default' => false,
  ],
  'top_template_path' => [
    'default' => 'page/home_static'
  ],

  /**
   * Logo
   */
  'logo' => array(
  ),

  'logo_initial_height' => [
    'default' => 48
  ],

  'logo_footer' => array(
  ),

  /**
   * Font
   */

  'font_default_name' => [
    'default' => 'Noto Sans JP'
  ],
  'font_default_url' => [
    'default' => '//fonts.googleapis.com/earlyaccess/notosansjapanese.css'
  ],
  'font_ornament_name' => [
    'default' => 'Shippori Mincho'
  ],
  'font_ornament_url' => [
    'default' => '//fonts.googleapis.com/css2?family=Shippori+Mincho&display=swap'
  ],

  /**
   * Appearance
   */

  'theme_background_color' => array(
    'default' => '#eee',
    'control' => array(
      'label' => '背景色',
      'description' => ''
    )
  ),

  'theme_background_opacity' => array(
    'default' => '40',
    'control' => array(
      'description' => '背景透過度'
    )
  ),

  'theme_background_font_color_visibility' => array(
    'default' => '#2f2f2f',
    'control' => array(
      'label' => '背景色対応フォントカラー',
      'description' => '指定した色が .theme-font-color-background-escape に反映されます'
    )
  ),

  'theme_background_image' => array(
    'default' => '',
    'control' => array(
      'label' => '背景画像マスクレイヤー',
    )
  ),

  'theme_background_image_size' => array(
    'default' => 'cover',
    'control' => array(
      'label' => '背景画像マスクレイヤー：サイズ',
      'choices' => array('cover' => 'cover', 'repeat' => 'repeat')
    )
  ),

  'theme_background_image_mask_opacity' => array(
    'default' => '25',
    'control' => array(
      'label' => '背景画像マスクレイヤー：透明度',
      'description' => 'format: 0-99'
    )
  ),

  'theme_background_image_mask_colorhex' => array(
    'default' => '0,0,0',
    'control' => array(
      'label' => '背景画像マスクレイヤー：色',
      'description' => 'format: 0-255, 0-255, 0-255',
    )
  ),

  'theme_header_background_color' => array(
    'default' => '#fefefe',
    'control' => array(
      'label' => 'ヘッダー：背景色'
    )
  ),
  'theme_header_background_initial_opacity' => array(
    'default' => 255,
    'control' => array(
    )
  ),
  'theme_header_background_stable_opacity' => array(
    'default' => 255,
    'control' => array(
    )
  ),
  'theme_header_font_color' => array(
    'default' => '#555555',
    'control' => array(
      'label' => 'ヘッダー：文字'
    )
  ),

  'footer_show_brand' => [
    'default' => true,
  ],
  'theme_footer_background_color' => array(
    'default' => '#404040',
    'control' => array(
      'label' => 'フッター：背景色'
    )
  ),

  'theme_footer_font_color' => array(
    'default' => '#ffffff',
    'control' => array(
      'label' => 'フッター：文字色`'
    )
  ),

  'section_background_color' => [
    'default' => '#ffffff'
  ],
  'section_background_opacity' => [
    'default' => '255'
  ],
  'section_font_color' => [
    'default' => '#2f2f2f'
  ],

  /**
   * Top
   */

  'top_use_template' => [
    'default' => false
  ],
  'top_static_primary_posts' => [
    'default' => ''
  ],
  'top_static_secondary_posts' => [
    'default' => ''
  ],

  /**
   * Jumbotron
   */
  'jumbotron_active' => [
    'default' => true,
  ],
  'jumbotron_url_post_meta_key' => array(
    'default' => 'url',
    'control' => array(
      'label' => 'URL用カスタムフィールド名',
      'description' => '投稿作成時の、カスタムフィールドの項目にて下記の名前の項目を登録すると、トップスライダーの各リンク先を変更できます。'
    )
  ),
  'jumbotron_post_type' => array(
    'default' => 'post',
    'control' => array(
      'label' => 'ジャンボトロン-投稿タイプ',
      'description' => 'ジャンボトロンとして表示する記事の投稿タイプを指定します。(別途追加している場合など)'
    )
  ),
  'jumbotron_category' => array(
    'default' => 'featured',
    'control' => array(
      'label' => 'ジャンボトロン-カテゴリー',
      'description' => 'ジャンボトロンとして表示する記事のカテゴリーを指定します。'
    )
  ),
  'jumbotron_caption_active' => [
    'default' => true
  ],
  'jumbotron_caption_stroke' => [
    'default' => true
  ],
  'jumbotron_caption_stroke_color' => [
    'default' => '#ffffff'
  ],
  'jumbotron_caption_stroke_opacity' => [
    'default' => '0.8'
  ],
  'jumbotron_caption_stroke_width' => [
    'default' => '.275em'
  ],

  'post_show_related_article' => [
    'default' => true
  ],
  'post_show_date' => [
    'default' => true
  ],
  'post_show_time' => [
    'default' => true
  ],

  'post_comment_disabled_category_list' => array(
    'control' => array(
      'label' => 'コメント非許可カテゴリ',
      'description' => '指定したカテゴリの記事に対してコメント機能を無効化します。'
    )
  ),
  'post_article_list_noimage_url' => array(
    'control' => array(
      'label' => 'アイキャッチ未指定用イメージ',
      'description' => 'アイキャッチ画像が未指定の場合、指定された画像を表示します。'
    )
  ),
  'post_article_list_read_more_label' => array(
    'default' => 'Read More &raquo;',
    'control' => array(
      'label' => '記事一覧: 『もっと見る』用ラベル',
      'description' => ''
    )
  ),
  'post_badge_new_interval' => array(
    'default' => 7,
    'control' => array(
      'label' => '投稿: NEWバッヂ表示期間(単位: 日)',
      'description' => '',
    )
  ),
  'post_meta_key_eyecatch_link' => array(
    'default' => 'url',
    'control' => array(
      'label' => 'カスタムフィールド: アイキャッチ外部URL',
      'description' => ''
    )
  ),

  'sidebar_toggle' => array(
    'default' => false,
    'control' => array(
      'label' => 'サイドバー　有効化'
    )
  ),
  'sidebar_align' => array(
    'default' => 'right',
    'control' => array(
      'label' => 'サイドバー　位置',
      'choices' => array('left' => __('left'), 'right' => __('right'))
    )
  ),
  'sidebar_post_type' => array(
    'default' => 'post',
    'control' => array(
      'label' => 'サイドバー　投稿タイプ'
    )
  ),
  'sidebar_head_category' => array(
    'default' => 'sidebar-head',
    'control' => array(
      'label' => 'ヘッダー カテゴリー'
    )
  ),
  'sidebar_head_last_activated_time' => array(
    'default' => 0,
    'control' => array(
      'label' => 'ヘッダー 最終更新日',
      'description' => '最終のヘッダー更新日です。'
    )
  ),
  'sidebar_head_last_increment' => array(
    'default' => 1,
    'control' => array(
      'label' => 'ヘッダー 最終投稿インデックス',
      'description' => '現在表示中の投稿のインデックスです。'
    )
  ),
  'sidebar_head_last_toggle_margin' => array(
    'default' => ($d = 60*60*24*7),
    'control' => array(
      'label' => 'ヘッダー 更新間隔',
      'description' => 'サイドーバー・ヘッダー部の内容の更新間隔を秒で指定します。初期値:'.$d
    )
  ),
  'sidebar_post_meta_key_url' => array(
    'default' => 'url',
    'control' => array(
      'label' => 'URL用カスタムフィールド名',
      'description' => 'サイドバーに表示する記事をクリックした際に外部URLへ移動します。'
    )
  ),
  'sidebar_post_meta_key_open_tab' => array(
    'default' => 'open_new_tab',
    'control' => array(
      'label' => 'サイドバナーリンク 新タブ表示可否',
      'description' => 'リンクを新規タブで開くか 1 or 0 で指定します。'
    )
  ),
  'sidebar_menu_category' => array(
    'default' => 'sidebar-menu',
    'control' => array(
      'label' => 'メニュー小 カテゴリー'
    )
  ),
  'sidebar_custom_field_banner_url_v' => array(
    'default' => 'sidebar-banner-url-vertical',
    'control' => array(
      'label' => '画像URL用カスタムフィールド(縦)',
      'description' => ''
    )
  ),
  'sidebar_custom_field_banner_url_h' => array(
    'default' => 'sidebar-banner-url-horizontal',
    'control' => array(
      'label' => '画像URL用カスタムフィールド(横)',
      'description' => ''
    )
  ),

);
