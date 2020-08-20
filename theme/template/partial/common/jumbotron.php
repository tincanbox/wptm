<?php

if(is_home()){

?>
<div class="kamisibai">

<link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/static/vendor/owl.carousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/static/vendor/owl.carousel/assets/owl.theme.default.min.css">
<script src="<?php echo get_bloginfo('template_directory'); ?>/static/vendor/owl.carousel/owl.carousel.min.js"></script>
<?php

$posts = get_posts(array_merge(array(
  'posts_per_page'   => 8,
  'category_name'    => WPTM::option('jumbotron_category'),
  'orderby'          => 'date',
  'order'            => 'DESC',
  'post_type'        => array(WPTM::option('jumbotron_post_type')),
  #'post_mime_type'   => '',
  #'post_parent'      => '',
  #'author'     => '',
  'post_status'      => 'publish',
  'suppress_filters' => true
), @$query ? $query : array()));

?>
<div class="owl-carousel owl-theme">
<?php

foreach($posts as $post){
  setup_postdata($GLOBALS['post'] =& $post);
  $image_uri = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
  $k = WPTM::option('jumbotron_url_post_meta_key');
  $meta = $k ? get_post_meta($post->ID, $k) : array();
  $link = @$meta[0] ? $meta[0] : get_permalink();
  ?>
  <a
    class="jumbotron-slide-image"
    href="<?php echo $link; ?>"
    style="display: block; background-image: url('<?php echo $image_uri[0]; ?>'); background-position: center center; background-size: cover; width: 100%;">
  </a>
  <?php
  wp_reset_postdata();
}

?>
</div>

<script>
$(function(){
  $(document).ready(function(){
    $(".owl-carousel").owlCarousel({
      items: 1,
      loop: true,
      autoplay: true,
      autoplayTimeout: 4000,
      autoplayHoverPause: true
    });
  });
});
</script>

</div>

<?php } ?>