<div class="page-article-single">
<?php

$mq = $main_query;

while($mq->have_posts()){
  global $post;
  $mq->the_post();
  $post = get_post();

  $query_related = array(
    'post__not_in' => array($post->ID),
    'tax_query' => array(
      'relation' => 'or'
    )
  );
  $tax_query = array(
    'relation' => 'or'
  );

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
    $is_available = WPTM::option('post_show_tag_list');

    if($is_available && $tags){
      ?>
      <div class="post-tag-area">
        <div class="caption"><?php echo _e('Tags'); ?></div>
      <?php
      foreach($tags as $c){
        $query_tag_in[] = $c->term_id;
        ?><span class="slug-pill post-tag tag-<?php echo $c->slug; ?>">
          <a class="post-tag-link link" href="<?php echo get_tag_link($c->term_id); ?>"><?php echo $c->name; ?></a>
        </span><?php
      }
      ?>
      </div>
      <?php
    }
  ?>

  <?php
  // Related categories

  $conf = WPTM::option('category');
  $categories = get_the_category();
  $query_category_in = array();
  
  $is_category_list_disabled = (!@WPTM::option('post_show_category_list')) || false;

  if($categories){
    if(!$is_category_list_disabled){
      ?>
      <div class="post-category-area">
        <div class="caption"><?php echo _e('Categories'); ?></div>
      <?php
    }
    foreach($categories as $c){
      $cnfc = @$conf[$c->slug];
      if(!@$cnfc){
        continue;
      }

      $query_category_in[] = $c->cat_ID;
      if(@$cnfc['is_active']){
        ?>
        <span class="slug-pill post-category category-<?php echo $c->slug; ?>">
          <a class="post-category-link link" href="<?php echo get_category_link($c->cat_ID); ?>"><?php echo $c->name; ?></a>
        </span>
        <?php
      }
    }
    if(!$is_category_list_disabled){
      ?></div><?php
    }
  }

  if($post->post_type){
    $query_related['post_type'] = $post->post_type;
  }

?>

  </div>

  <?php

  if($query_category_in){
    $tax_query[] = array(
      'taxonomy' => 'category',
      'field'    => 'term_id',
      'terms'    => $query_category_in,
    );
    //$query_related['category__in'] = $query_category_in;
  }

  if($query_tag_in){
    $tax_query[] = array(
     'taxonomy' => 'tag',
     'field'    => 'term_id',
     'terms'    => $query_tag_in,
    );
  }

  $query_related['tax_query'][] = $tax_query;

  ?>

  <div class="section mb-3">
  <?php
  // Related articles
  WPTM::render('template/partial/article/list/group_related', array(
    'main_query' => $main_query,
    'show_group_caption' => true,
    'group_caption' => __('Related Contents'),
    'list_type' => 'with_picture',
    'query' => $query_related
  ));

  ?>
  </div>

  <?php
  // Comments
  $is_comment_disabled = false;

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
