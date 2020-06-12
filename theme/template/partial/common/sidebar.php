<?php if( WPTM::option('sidebar_toggle') == 1){ ?>
<div class="sidebar">


  <div style="margin-bottom: 1.4em;"><?php

    $posts = get_posts(array_merge(array(
      'posts_per_page'   => 0,
      #'offset'           => 0,
      #'category'         => '',
      'category_name'    => WPTM::option('sidebar_head_category'),
      'orderby'          => 'date',
      'order'            => 'DESC',
      #'include'          => '',
      #'exclude'          => '',
      #'meta_key'         => '',
      #'meta_value'       => '',
      'post_type'        => WPTM::option('sidebar_post_type'),
      #'post_mime_type'   => '',
      #'post_parent'      => '',
      #'author'     => '',
      'post_status'      => 'publish',
      'suppress_filters' => true
    ), @$query ? $query : array()));

    # Sidebar Header Auto-Rotation.
    #
    #

    $incr = WPTM::option('sidebar_head_last_increment');
    if(!$incr){
      WPTM::option('sidebar_head_last_increment', 1);
      $incr = 1;
    }
    if($incr > count($posts)){
      WPTM::option('sidebar_head_last_increment', 1);
      $incr = 1;
    }

    $now = time();
    $last_time = (int)WPTM::option('sidebar_head_last_activated_time');
    $margin    = (int)WPTM::option('sidebar_head_last_toggle_margin');
    if(!$last_time){
      $last_time = $now;
      WPTM::option('sidebar_head_last_activated_time', $now);
    }
    if(!$margin){
      $margin = 60 * 60 * 24;
      WPTM::option('sidebar_head_last_toggle_margin', $margin);
    }
    if($now > $last_time + $margin){
      $incr += 1;
      if($incr > count($posts)){
        $incr = 1;
      }
      WPTM::option('sidebar_head_last_activated_time', $now);
      WPTM::option('sidebar_head_last_increment', $incr);
    }
    # Rotation END

    # Pickup Post
    $post = @$posts[$incr - 1];

    if($post){
       setup_postdata($GLOBALS['post'] =& $post);

      $img = get_the_post_thumbnail_url();

      $k = WPTM::option('sidebar_custom_field_banner_url_v');
      $meta = $k ? get_post_meta($post->ID, $k) : array();
      $imgv = @$meta[0] ? $meta[0] : get_the_post_thumbnail_url();

      $k = WPTM::option('sidebar_post_meta_key_url');
      $meta = $k ? get_post_meta($post->ID, $k) : array();
      $link = @$meta[0] ? $meta[0] : null;

      $k = WPTM::option('sidebar_post_meta_key_open_tab');
      $meta = $k ? get_post_meta($post->ID, $k) : array();
      $tab = @$meta[0] ? $meta[0] : null;

      ?>

      <a
        class="sidebar-head-area hidden-xs hidden-sm"
        target="<?php echo $tab ? '_blank' : ''; ?>"
        href="<?php echo $link ? $link : get_permalink(); ?>">
        <div
          class="sidebar-head-thumbnail vertical"
          style="<?php echo @$imgv ? "background-image:url('".$imgv."');" : ''; ?>"></div>
      </a>

      <a
        class="sidebar-head-area visible-xs visible-sm"
        style="margin-top: 2.8em;"
        target="<?php echo $tab ? '_blank' : ''; ?>"
        href="<?php echo $link ? $link : get_permalink(); ?>">
        <div
          class="sidebar-head-thumbnail horizontal"
          style="<?php echo @$imgv ? "background-image:url('".$imgv."');" : ''; ?> background-position: center 0;"></div>
      </a>

      <?php

      wp_reset_postdata($post);

    }
  ?></div>


  <div class="row"><?php

    $posts = get_posts(array_merge(array(
      'posts_per_page'   => 24,
      #'offset'           => 0,
      #'category'         => '',
      'category_name'    => WPTM::option('sidebar_menu_category'),
      'orderby'          => 'date',
      'order'            => 'DESC',
      #'include'          => '',
      #'exclude'          => '',
      #'meta_key'         => '',
      #'meta_value'       => '',
      'post_type'        => WPTM::option('sidebar_post_type'),
      #'post_mime_type'   => '',
      #'post_parent'      => '',
      #'author'     => '',
      'post_status'      => 'publish',
      'suppress_filters' => true
    ), @$query ? $query : array()));

    foreach($posts as $post){ setup_postdata($GLOBALS['post'] =& $post);

      $img = get_the_post_thumbnail_url();

      $k = WPTM::option('sidebar_custom_field_banner_url_h');
      $meta = $k ? get_post_meta($post->ID, $k) : array();
      $img = @$meta[0] ? $meta[0] : get_the_post_thumbnail_url();

      $k = WPTM::option('sidebar_post_meta_key_url');
      $meta = $k ? get_post_meta($post->ID, $k) : array();
      $link = @$meta[0] ? $meta[0] : null;

      $k = WPTM::option('sidebar_post_meta_key_open_tab');
      $meta = $k ? get_post_meta($post->ID, $k) : array();
      $tab = @$meta[0] ? $meta[0] : null;

      ?>

      <a
        class="sidebar-menu-area col-xs-6 col-sm-6 col-md-12" style=""
        target="<?php echo $tab ? '_blank' : ''; ?>"
        href="<?php echo $link ? $link : get_permalink(); ?>">
        <?php if($img): ?>
          <div
            class="sidebar-menu-thumbnail"
            style="<?php echo @$img ? "background-image:url('".$img."');" : ''; ?>"></div>
        <?php endif; ?>
      </a>

      <?php

      wp_reset_postdata($post);
    }

  ?></div>


</div>
<? } ?>