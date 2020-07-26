<!-- You can use Open Graph tags to customize link previews.
       Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
<?php

$og = array(
  'app_id' => WPTM::option('facebook_app_id'),
  'url' => get_bloginfo('url'),
  'title' => get_bloginfo('name'),
  'description' => get_bloginfo('description'),
  'image' => WPTM::option('logo')
);

$q = @$this->variables['main_query'];

if($q && $q->is_single()){
  $ps = $q->get_posts();
  $p = $ps[0];
  $is = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'full');
  $og['url'] = get_permalink($p->ID);
  $og['title'] = get_bloginfo('name').' | '.$p->post_title;
  $og['description'] = @$p->post_excerpt ? $p->post_excerpt : $og['description'];
  $og['image'] = @$is[0] ? $is[0] : $og['image'];
}

if($og['image']){
  $path = str_replace(get_bloginfo('wpurl'), ABSPATH, $og['image']);
  if(file_exists($path)){
    $s = getimagesize($path);
    if($s){
      $og['image_width'] = $s[0];
      $og['image_height'] = $s[1];
    }
  }
}

?>
<meta property="fb:app_id" content="<?php echo $og['app_id']; ?>">
<meta property="og:url"           content="<?php echo $og['url']; ?>" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="<?php echo $og['title']; ?>" />
<meta property="og:description"   content="<?php echo $og['description']; ?>" />
<meta property="og:image"         content="<?php echo $og['image']; ?>" />
<meta property="og:image:width" content="<?php echo @$og['image_width']; ?>" />
<meta property="og:image:height" content="<?php echo @$og['image_height']; ?>" />
<!-- Load Facebook SDK for JavaScript -->
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.6";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
