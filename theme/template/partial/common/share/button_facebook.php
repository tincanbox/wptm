<style>
.fb-share-button {
  vertical-align: bottom;
}
</style>
<div
  class="fb-share-button"
  data-id="<?php echo @$post ? $post->ID : ""; ?>"
  data-href="<?php echo @$post ? get_post_permalink($post->ID) : bloginfo('url'); ?>"
  data-layout="button"></div>
