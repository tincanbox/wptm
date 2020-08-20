<div class="container">
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

  </div>

  <?php
  // Finally closes all postdata.
  wp_reset_postdata();

}

?>

</div>
</div>