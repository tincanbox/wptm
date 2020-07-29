<div class="page-article-single">
<?php

$mq = $main_query;

while($mq->have_posts()){ $mq->the_post(); $post = get_post();

  ?>

  <div class="post-title section append closing">
    <h2 class="mb-0"><?php the_title(); ?></h2>
  </div>

  <?php if(has_post_thumbnail()): ?>
    <div class="post-image">
      <?php

      $k = WPTM::option('post_meta_key_eyecatch_link');
      $meta = $k ? get_post_meta($post->ID, $k) : array();
      $val = @$meta[0] ? $meta[0] : null;

      ?>
      <div class="post-thumbnail"><?php
        if($val){
          ?><a href="<?php echo $val; ?>" target="_blank"><?php
            the_post_thumbnail('full');
          ?></a><?php
        }else{
          the_post_thumbnail('full');
        }
      ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="post-content section prepend closing spacing">

    <?php if(WPTM::option('post_show_time')){ ?>
      <div class="post-time">
        <span class="date"><?php the_time('Y.m.d'); ?></span> <span class="time"><?php echo the_time('H:i'); ?></span>
      </div>
    <?php } ?>
    <div class="post-yield">
      <div class="post-content"><?php the_content(); ?></div>
    </div>

    <?php WPTM::render('template/partial/common/share/bootstrap_single', array(
      'post' => $post
    )); ?>

    <?php

    $tags = get_the_tags();
    $query_tag_in = array();
    if($tags){
      ?><div class="post-tag-area"><h4 class="caption"><?php echo _e('Tags'); ?></h4><?php
      foreach($tags as $c){
        $query_tag_in[] = $c->term_id;
        ?><span class="slug-pill post-tag tag-<?php echo $c->slug; ?>">
          <a class="post-tag-link" href="<?php echo get_tag_link($c->term_id); ?>"><?php echo $c->name; ?></a>
        </span><?php
      }
      ?>
      </div>
      <?php
    }
  ?>

  <?php
  // Related categories

  $is_comment_disabled = false;
  $categories = get_the_category();
  $query_category_in = array();
  $disabled = WPTM::option('post_comment_disabled_category_list');
  
  $is_category_list_disabled = (!@WPTM::option('post_show_category_list')) || false;

  if($categories){
    if(!$is_category_list_disabled){
      ?><div class="post-category-area"><h4 class="caption"><?php echo _e('Categories'); ?></h4><?php
    }
    foreach($categories as $c){
      $query_category_in[] = $c->cat_ID;
      if($disabled){
        $f = @$disabled[$c->slug];
        if($f){
          $is_comment_disabled = true;
        }else{
          if($f === false){
            $is_comment_disabled = false;
          }
        }
      }
      if(!$is_category_list_disabled){
        ?>
        <span class="slug-pill post-category category-<?php echo $c->slug; ?>">
          <a class="post-category-link" href="<?php echo get_category_link($c->cat_ID); ?>"><?php echo $c->name; ?></a>
        </span>
        <?php
      }
    }
    if(!$is_category_list_disabled){
      ?></div><?php
    }
  }

?>

  </div>

  <?php

  $q = array(
    'posts_per_page' => 3,
    'post__not_in' => array($post->ID),
  );

  $q['tax_query'] = array('relation' => 'OR');

  if($query_category_in){
    $q['tax_query'][] = array(
      'taxonomy' => 'category',
      'field'    => 'term_id',
      'terms'    => $query_category_in
    );
  }

  if($query_tag_in){
    $q['tax_query'][] = array(
      'taxonomy' => 'tag',
      'field'    => 'term_id',
      'terms'    => $query_tag_in
    );
  }

  ?>

  <div class="section mb-3">
  <?php
  // Related articles

  WPTM::render('template/partial/article/list/group_related', array(
    'show_group_caption' => true,
    'group_caption' => __('Related Contents'),
    'list_type' => 'with_picture',
    'post' => $post,
    'query' => $q
  ));

  ?>
  </div>

  <?php
  // Comments
  $s = $post;
  global $post;
  $post = $s;
  if(WPTM::option('post_allow_comment') && !$is_comment_disabled && (comments_open() || get_comments_number())){
    ?>
    <div class="section mb-3">
    <?php
    global $withcomments;
    $withcomments = 1;
    comments_template();
    ?>
    </div>
    <?php
  }

  // Finally closes all postdata.
  wp_reset_postdata();

}

?>

</div>
