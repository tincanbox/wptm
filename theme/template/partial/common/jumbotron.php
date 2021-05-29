<?php

if(is_home()){

?>
<div class="kamisibai wait-humble more-humble">

<style><?php

$stroke_width = WPTM::option('jumbotron_caption_stroke_width');
$stroke_color = WPTM::option('jumbotron_caption_stroke_color');
$stroke_opacity = WPTM::option('jumbotron_caption_stroke_opacity');
?>.jumbotron-caption text {
  stroke: <?php echo $stroke_color ?: '#ffffff'; ?>;
  stroke-width: <?php echo $stroke_width ?: '.25em'; ?>;
  stroke-opacity: <?php echo $stroke_opacity ?: '1'; ?>;
}<?php
?></style>

<link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/static/vendor/owl.carousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/static/vendor/owl.carousel/assets/owl.theme.default.min.css">
<script src="<?php echo get_bloginfo('template_directory'); ?>/static/vendor/owl.carousel/owl.carousel.min.js"></script>
<?php

$posts = get_posts(array_merge(array(
  'posts_per_page'   => 8,
  #'offset'           => 0,
  #'category'         => '',
  'category_name'    => WPTM::option('jumbotron_category'),
  'orderby'          => 'date',
  'order'            => 'DESC',
  #'include'          => '',
  #'exclude'          => '',
  #'meta_key'         => '',
  #'meta_value'       => '',
  'post_type'        => WPTM::option('jumbotron_post_type'),
  #'post_mime_type'   => '',
  #'post_parent'      => '',
  #'author'     => '',
  'post_status'      => 'publish',
  'suppress_filters' => true
), @$query ? $query : array()));

$no_link = WPTM::option('jumbotron_no_link');

?>
<div class="jumbotron-wrapper owl-carousel owl-theme">
<?php

foreach($posts as $post){
  setup_postdata($GLOBALS['post'] =& $post);
  $image_uri = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
  $k = WPTM::option('jumbotron_url_post_meta_key');
  $meta = $k ? get_post_meta($post->ID, $k) : array();
  $link = ($no_link) ? '' : (@$meta[0] ? $meta[0] : get_permalink());
  ?>
  <a
    class="jumbotron-slide-image theme-background-image-overlay"
    href="<?php echo $link; ?>"
    style="display: block; ">
    <div
      class="jumbotron-image fill"
      style="background-image: url('<?php echo $image_uri[0]; ?>');"
      ></div>
    <?php

    $lines = preg_split("/(<br>|\n|,|…|\/)/", get_the_title($post));

    ?>
    <svg class="jumbotron-caption" style="top: calc(50vh - <?php echo (1.8 * (count($lines))) / 2; ?>em);">
      <text
        class="theme-font-color-escape"
        x="0" y="50"
        ><?php
          echo implode('', array_map(function ($text, $i) {
            return '<tspan x=".5em" dy="'.($i ? 1.8 : 0).'em">' . $text . '</tspan>';
          }, $lines, range(0, count($lines) - 1)));
        ?></text>
    </svg>
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
      <?php if (count($posts) > 1){ ?> 
      loop: true,
      <?php } ?>
      autoplay: true,
      autoplayTimeout: 4000,
      autoplayHoverPause: true
    });
  });
});
</script>

</div>

<?php } ?>