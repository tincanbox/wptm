<?php

$style_group = "article";
$article_group = WPTM::get_article_group_config(array('ordered' => true));
extract($theme_vars);

?>

<?php

/**
 * Web Font
 */

if ($font_default_url) {
  ?>
  <link href='<?php echo $font_default_url; ?>' rel='stylesheet' type='text/css'>
  <?php
}

if ($font_ornament_url) {
  ?>
  <link href='<?php echo $font_ornament_url; ?>' rel='stylesheet' type='text/css'><?php
}

$theme_background_rgba = '';

if($theme_background_color){
  $theme_background_rgba = $theme_background_color;
  if($theme_background_opacity !== null){
    $theme_background_rgba .= str_pad(dechex(intval($theme_background_opacity)), 2, "0", STR_PAD_LEFT);
  }
}

$section_background_rgba = '';

if($section_background_color){
  $section_background_rgba = $section_background_color;
  if($section_background_opacity !== null){
    $section_background_rgba .= str_pad(dechex(intval($section_background_opacity)), 2, "0", STR_PAD_LEFT);
  }
}

$theme_header_background_initial_rgba = '';
$theme_header_background_stable_rgba = '';

if($theme_header_background_color){
  $theme_header_background_initial_rgba = $theme_header_background_color;
  $theme_header_background_stable_rgba = $theme_header_background_color;

  if($theme_header_background_initial_opacity >= 0){
    $theme_header_background_initial_rgba
      .= str_pad(dechex(intval($theme_header_background_initial_opacity)), 2, "0", STR_PAD_LEFT);
  }
  if($theme_header_background_stable_opacity >= 0){
    $theme_header_background_stable_rgba
      .= str_pad(dechex(intval($theme_header_background_stable_opacity)), 2, "0", STR_PAD_LEFT);
  }
}

?>
<style id="theme-override-basis">
html,body {
  font-family: <?php
    echo ($font_default_name ? $font_default_name . ', ' : '');
  ?> "Montserrat","游ゴシック",YuGothic,"ヒラギノ角ゴ ProN W3","Hiragino Kaku Gothic ProN","メイリオ",Meiryo, -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  background-color: <?php echo $theme_background_color; ?>;
}
.font-ornament {
  font-family: <?php echo $font_ornament_name;?>, Arial;
}
h1, h2, h3, h4, h5, dt, th {
  font-family: <?php echo $font_ornament_name;?>, Arial;
}
<?php if ($v = WPTM::option('post_content_caption_ornament')) { ?>
.post-content > h1,
.post-content > h2,
.post-content > h3,
.post-content > h4,
.post-content > h5 {
  padding-left: 1.8em;
  position: relative;
}
.post-content > h1:after,
.post-content > h2:after,
.post-content > h3:after,
.post-content > h4:after,
.post-content > h5:after {
  content: '';
  display: inline-block;
  background-image: url('<?php echo $v; ?>');
  background-size: contain;
  background-repeat: no-repeat;
  position: absolute;
  left: 0;
  width: 1.8em;
  height: 1.25em;
}
<?php } ?>
</style>

<?php
/*--------------------------------------------------------------------------
 * #content
 *--------------------------------------------------------------------------
 */
?>
<style id="theme-override-content">
<?php

$target_wrapper = '#content';

?>
<?php
echo $target_wrapper; ?>:after {
  background-color: <?php echo $theme_background_color; ?>;
} 
<?php if($theme_background_image){ ?>
<?php echo $target_wrapper; ?>:before {
  background-image: url('<?php echo $theme_background_image; ?>');
  <?php if ($theme_background_opacity !== null) { ?>
    opacity: <?php echo (100 - ((100/255) * $theme_background_opacity)) * 0.01; ?>;
  <?php }else{ ?>
    opacity: 1;
  <?php } ?>
  <?php if($theme_background_image_size){ ?>
    background-size: <?php echo $theme_background_image_size; ?>;
    <?php if($theme_background_image_size == 'cover'){ ?>
    background-repeat: no-repeat;
    <?php } ?>
  <?php } ?>
}
<?php } ?>
.theme-background-image-overlay {
  background-color: <?php echo $theme_background_color; ?>;
}
.theme-background-image-overlay .fill {
  hoge: <?php $theme_background_opacity; ?>;
}
.theme-background-image-overlay .fill {
  opacity: <?php echo (100 - ((100/255) * $theme_background_opacity)) * 0.01; ?>;
}
.section:after {
  background-color: <?php echo $section_background_rgba; ?>;
  color: <?php echo $section_font_color; ?>
}
.section * {
  color: <?php echo $section_font_color; ?>
}
.section .link:hover {
  color: <?php echo $section_font_color; ?>
}
</style>

<?php
/*--------------------------------------------------------------------------
 * Theme Font Color
 *--------------------------------------------------------------------------
 */

?>
<style id="theme-override-font-color">
<?php
if($theme_background_font_color_visibility){ ?>
.theme-font-color,
.theme-font-color-escape, .theme-font-color-escape #svg,
.theme-font-color-escape:hover, .theme-font-color-escape #svg:hover {
  color: <?php echo $theme_background_font_color_visibility; ?>;
  fill: <?php echo $theme_background_font_color_visibility; ?>;
}
a, .link {
  color: <?php echo $theme_background_font_color_visibility; ?>;
}
a:hover, .link:hover {
  color: <?php echo $theme_background_font_color_visibility; ?>;
  text-decoration: none;
}
<?php } ?>
</style>

<?php
/*--------------------------------------------------------------------------
 * Header
 *--------------------------------------------------------------------------
 */
?>
<style id="theme-override-header">
<?php
?>
#header {
  background-color: <?php echo $theme_header_background_initial_rgba; ?>;
}
<?php if ($v = WPTM::option('logo_initial_height')) { ?>
#header .navbar-brand img { max-height: <?php echo $v; ?>px; }
#header:not(.humble) .navbar-brand img { max-height: <?php echo $v; ?>px; }
<?php } ?>
#header:not(.humble) .mobile-only .site-nav-menu {
  background-color: <?php echo $theme_header_background_stable_rgba; ?>;
}
#header.humble.theme-header-background-color,
.theme-header-background-color-with-alpha {
  background-color: <?php echo $theme_header_background_stable_rgba; ?>;
}
#header .desktop-only .dropdown-menu {
  background-color: <?php echo $theme_header_background_stable_rgba; ?>;
}
#header .mobile-only .dropdown-menu {
  background-color: transparent;
}
#header .dropdown-toggle::after {
  display: flex;
  align-self: center;
  margin-left: .6rem;
}
#header .navbar-nav > li > a > .site-nav-interactive:before {
  background-color: <?php echo $theme_header_font_color; ?>;
}
.theme-header-background-color .bordered {
  border: 2px solid <?php echo $theme_header_font_color; ?>;
}
<?php

if($theme_header_background_initial_opacity == 255){ ?>
  #header + #content {
    margin-top: 86px;
  }
  <?php
}
?>
<?php # Header
if($theme_header_background_color){ ?>
.theme-header-background-color {
  background-color: <?php echo $theme_header_background_color; ?>;
}
<?php } ?>
<?php
if($theme_header_font_color){ ?>
.theme-header-font-color,
.theme-header-font-color:hover {
  color: <?php echo $theme_header_font_color; ?>
}
.theme-header-background-color-escape {
  background-color: <?php echo $theme_header_font_color; ?>
}
<?php } ?>
</style>

<style id="theme-override-footer">
<?php
# Footer
if($theme_footer_background_color){ ?>
.theme-footer-background-color {
  background-color: <?php echo $theme_footer_background_color; ?>;
}
<?php } ?>

<?php
# Footer font
if($theme_footer_font_color){ ?>
.theme-footer-font-color, .theme-footer-font-color *,
.theme-footer-font-color:hover, .theme-footer-font-color *:hover
{
  color:  <?php echo $theme_footer_font_color; ?>
}
<?php } ?>

.theme-<?php echo $style_group; ?>-icon {
  width: 1.1em;
  height: 1.1em;
  display: inline-block;
  background-size: contain;
  vertical-align: middle;
  background-position: center;
}
</style>

<style id="theme-override-group">
<?php
// Reversing cuz latter CSS means higher priority.
foreach(array_reverse($article_group) as $p => $l){
  foreach($l as $c){

  $prefix = $c['type'];
  $slug = $c['slug'];
  $group_background_color = @$c['theme_background_color'] ?: '#ffffff';

  $group_background_opacity = @$c['theme_background_opacity'] ?: $theme_background_opacity;
  $group_background_rgba = null;
  $group_font_color_visibility = @$c['theme_background_font_color_visibility'];

  if($group_background_color && $group_background_opacity){
    $group_background_rgba
      = $group_background_color . str_pad(dechex(intval($group_background_opacity)), 2, "0", STR_PAD_LEFT);
  }
  ?>
  body.<?php echo $prefix; ?>-<?php echo $slug; ?> #content:before
    { content: ''; display: block; position: absolute; top: 0; right: 0; bottom: 0; left: 0; }
  <?php
  // Background Image
  if($v = @$c['theme_background_image']){
    ?>
    body.single.<?php echo $prefix; ?>-<?php echo $slug; ?> #content {
      background-image: url('<?php echo $v; ?>');
      background-position: center;
      background-attachment: fixed;
      <?php if($v = @$c['theme_background_image_size']){ ?>
        background-size: <?php echo $v; ?>;
        <?php if($v == 'cover'){ ?>
        background-repeat: no-repeat;
        <?php } ?>
      <?php } ?>
    }
    <?php
  }

  if ($group_background_rgba) {
    ?>
    body.single.<?php echo $prefix; ?>-<?php echo $slug; ?> #content:before {
      background-color: <?php echo $group_background_rgba; ?>;
    }
    <?php
  }

  // .article-category .category-something 
  if ($group_background_color) {
    ?>
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?>.<?php echo $style_group; ?>-font-color,
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?>.<?php echo $style_group; ?>-font-color:hover
      { color: <?php echo $group_background_color; ?>;
        fill: <?php echo $group_background_color; ?>; }
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?>.<?php echo $style_group; ?>-background-color
      { background-color: <?php echo $group_background_color; ?>; }
    .<?php echo $prefix; ?>-<?php echo $slug; ?>-font-color
      { color: <?php echo $group_background_color; ?>; }
    .<?php echo $prefix; ?>-<?php echo $slug; ?>-background-color
      { background-color: <?php echo $group_background_color; ?>; }
    <?php
  }

  if($group_font_color_visibility){
    ?>
    .<?php echo $prefix; ?>-<?php echo $slug; ?>-font-color-escape
      { color: <?php echo $group_font_color_visibility; ?>; }
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?>.<?php echo $style_group; ?>-font-color-escape,
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?>.<?php echo $style_group; ?>-font-color-escape:hover
      { color: <?php echo $group_font_color_visibility; ?>;
        fill: <?php echo $group_font_color_visibility; ?>; }
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?>.<?php echo $style_group; ?>-background-color-escape,
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?>.<?php echo $style_group; ?>-background-color-escape:hover
      { background-color: <?php echo $group_font_color_visibility; ?>; }
    <?php
  }
  ?>
<?php
  }
}
?>
</style>
