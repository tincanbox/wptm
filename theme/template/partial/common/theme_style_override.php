<?php

$style_group = "article";
$article_group = WPTM::get_article_group_config(array('ordered' => true));
extract($theme_vars);

?>

<?php if ($font_primary_url) { ?>
  <link href='<?php echo $font_primary_url; ?>' rel='stylesheet' type='text/css'>
<?php } ?>
<?php

$theme_background_rgba = '';

if($theme_background_color){
  $theme_background_rgba = $theme_background_color;
  if($theme_background_opacity){
    $theme_background_rgba .= str_pad(dechex(intval($theme_background_opacity)), 2, "0", STR_PAD_LEFT);
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
.font-primary {
  font-family: <?php echo $font_primary_name; ?>;
}
html,body {
  font-family: <?php echo ($font_primary_name ? $font_primary_name . ', ' : ''); ?> "Montserrat","游ゴシック",YuGothic,"ヒラギノ角ゴ ProN W3","Hiragino Kaku Gothic ProN","メイリオ",Meiryo, -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  background-color: <?php echo $theme_background_color; ?>;
}
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
echo $target_wrapper; ?>::before {
  content: '';
  display: block;
  position: absolute;
  top: 0; right: 0; bottom: 0; left: 0;
}

<?php
echo $target_wrapper; ?>::before {
  background-color: <?php echo $theme_background_rgba ?>;
} 

.theme-background-image-overlay {
  background-color: <?php echo $theme_background_color; ?>;
}
.theme-background-image-overlay .fill {
  opacity: <?php echo (100 - ((100/255) * $theme_background_opacity)) * 0.01; ?>;
}

<?php if($theme_background_image){ ?>
<?php echo $target_wrapper; ?> {
  background-image: url('<?php echo $theme_background_image; ?>');
  background-position: center;
  background-attachment: fixed;
  <?php if($theme_background_image_size){ ?>
    background-size: <?php echo $theme_background_image_size; ?>;
    <?php if($theme_background_image_size == 'cover'){ ?>
    background-repeat: no-repeat;
    <?php } ?>
  <?php } ?>
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
  box-shadow: 0 0 4px rgba(0, 0, 0, 0);
}
#header:not(.humble) .mobile-only .navbar-nav {
  background-color: <?php echo $theme_header_background_stable_rgba; ?>;
}
#header.humble.theme-header-background-color,
.theme-header-background-color-with-alpha {
  background-color: <?php echo $theme_header_background_stable_rgba; ?>;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.75);
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

<?php
/*--------------------------------------------------------------------------
 * Background
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
<?php } ?>

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

<style id="theme-override-category">
<?php
// Reversing cuz latter CSS means higher priority.
foreach(array_reverse($article_group) as $p => $l){
  foreach($l as $c){

  $prefix = $c['type'];
  $slug = $c['slug'];
  $group_background_color = @$c['theme_background_color'];
  $group_background_opacity = @$c['theme_background_opacity'] ?: $theme_background_opacity;
  $group_font_color_visibility = @$c['theme_background_font_color_visibility'];

  ?>
  body.<?php echo $prefix; ?>-<?php echo $slug; ?> #content:before
    { content: ''; display: block; position: absolute; top: 0; right: 0; bottom: 0; left: 0; }

  <?php if($v = @$c['theme_background_image']){ ?>
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
  <?php } ?>

  <?php if($v = @$c['theme_background_color']){ ?>
    body.single.<?php echo $prefix; ?>-<?php echo $slug; ?> #content:before {
      background-color: <?php echo $v ?><?php
      if($group_background_opacity){
        echo str_pad(dechex(intval($group_background_opacity)), 2, "0", STR_PAD_LEFT);
      }
      ?>;
    }
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-font-color,
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-font-color:hover
      { color: <?php echo $group_background_color; ?>; fill: <?php echo $group_background_color; ?>; }
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-background-color
      { background-color: <?php echo $group_background_color; ?>; }
  <?php } ?>

  .<?php echo $prefix; ?>-<?php echo $slug; ?>-font-color
    { color: <?php echo $group_background_color; ?>; }
  .<?php echo $prefix; ?>-<?php echo $slug; ?>-font-color-escape
    { color: <?php echo $group_font_color_visibility; ?>; }
  .<?php echo $prefix; ?>-<?php echo $slug; ?>-background-color
    { background-color: <?php echo $group_background_color; ?>; }

  <?php if($group_font_color_visibility): ?>
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-font-color-escape,
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-font-color-escape:hover
      { color: <?php echo $group_font_color_visibility; ?>; fill: <?php echo $group_font_color_visibility; ?>; }
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-background-color-escape,
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-background-color-escape:hover
      { background-color: <?php echo $group_font_color_visibility; ?>; }
  <?php endif; ?>

<?php

  }
}
?>
</style>