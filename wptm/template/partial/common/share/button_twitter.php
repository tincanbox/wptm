<style>
.twitter-share-button {
  vertical-align: bottom;
}
</style>
<a
  class="twitter-share-button"
  href="https://twitter.com/share"
  data-url="<?php echo @$url ? $url : bloginfo('url'); ?>"
  data-text="<?php echo @$text ? $text : get_bloginfo('title').' - '.get_bloginfo('description')."\n"; ?>"
  data-size=""></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
