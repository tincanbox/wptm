<link href='//fonts.googleapis.com/earlyaccess/notosansjapanese.css' rel='stylesheet' type='text/css'>

<?php

$theme_style = "";

$style_group = "article";
$article_group = WPTM::get_article_group_config(array('ordered' => true));

?>
<style>
html,body {
  font-family: 'Lato', 'Noto Sans JP', "Montserrat","Hiragino Maru Gothic ProN","メイリオ",Meiryo,"游ゴシック",YuGothic, -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  background-color: transparent;
}

#container::after {
  content: '';
  z-index: -99;
  display: block;
  position: fixed;
  top: 0; right: 0; bottom: 0; left: 0;
}

<?php if($v = @WPTM::option('theme_background_color')){ ?>
  #container::after {
    background-color: <?php echo $v ?><?php
    if($v = @WPTM::option('theme_background_opacity')){
      echo str_pad(dechex(intval($v)), 2, "0", STR_PAD_LEFT);
    }
    ?>; }
<?php } ?>
<?php
# Background
if($v = WPTM::option('theme_background_font_color_visibility')){ ?>
.theme-font-color-escape, .theme-font-color-escape #svg,
.theme-font-color-escape:hover, .theme-font-color-escape #svg:hover {
  color: <?php echo $v; ?>;
  fill: <?php echo $v; ?>;
}
<?php } ?>

<?php if($v = WPTM::option('theme_background_image')){ ?>
#container::before{
  content: '';
  position: fixed;
  z-index: -100;
  top:0;
  right: 0;
  bottom: 0;
  left: 0;
  background-image: url('<?php echo $v; ?>');
  background-position: center;
  background-size: cover;
  <?php if($v = WPTM::option('theme_background_image_size')){ ?>
    background-size: <?php echo $v; ?>;
    <?php if($v == 'cover'){ ?>
    background-repeat: no-repeat;
    <?php } ?>
  <?php } ?>
}
<?php } ?>


<?php # Header
if($v = WPTM::option('theme_header_background_color')){ ?>
.theme-header-background-color {
  background-color: <?php echo $v; ?>;
}
<?php } ?>
<?php
if($v = WPTM::option('theme_header_font_color')){ ?>
.theme-header-font-color,
.theme-header-font-color:hover {
  color: <?php echo $v; ?>
}
.theme-header-background-color-escape {
  background-color: <?php echo $v; ?>;
}
<?php } ?>

<?php # Breadcrumb
if($v = WPTM::option('theme_breadcrumb_background_color')){ ?>
.theme-breadcrumb-background-color {
  background-color: <?php echo $v; ?>;
}
<?php } ?>
<?php
if($v = WPTM::option('theme_breadcrumb_font_color')){ ?>
.theme-breadcrumb-font-color,
.theme-breadcrumb-font-color:hover {
  color: <?php echo $v; ?>
}
.theme-breadcrumb-background-color-escape {
  background-color: <?php echo $v; ?>;
}
<?php } ?>

<?php
# Footer
if($v = WPTM::option('theme_footer_background_color')){ ?>
.theme-footer-background-color {
  background-color: <?php echo $v; ?>;
}
<?php } ?>

<?php
# Footer font
if($v = WPTM::option('theme_footer_font_color')){ ?>
.theme-footer-font-color, .theme-footer-font-color *,
.theme-footer-font-color:hover, .theme-footer-font-color *:hover
{
  color:  <?php echo $v; ?>
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
<?php
// Reversing cuz latter CSS means higher priority.
foreach(array_reverse($article_group) as $p => $l){
  foreach($l as $c){

  $prefix = $c['type'];
  $slug = $c['slug'];
  ?>
  body.<?php echo $prefix; ?>-<?php echo $slug; ?> #content::before {
    content: '';
    display: block;
    position: fixed;
    top: 0; right: 0; bottom: 0; left: 0;
    z-index: -6;
  }

  <?php if($v = @$c['theme_background_color'] && ($v_opa = @$c['theme_background_opacity'])){ ?>
    body.single.<?php echo $prefix; ?>-<?php echo $slug; ?> #content:before {
      content: '';
      z-index: -5;
      background-color: <?php echo $v ?><?php
      if($v_opa){
        echo str_pad(dechex(intval($v)), 2, "0", STR_PAD_LEFT);
      }
      ?>;
    }
  <?php } ?>
  <?php if($v = @$c['theme_background_color']){ ?>
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-font-color,
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-font-color:hover
    {
      color: <?php echo $v; ?>;
      fill: <?php echo $v; ?>;
    }
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-background-color
    {
      background-color: <?php echo $c['theme_background_color']; ?>;
    }
  <?php } ?>

  <?php if($v = @$c['theme_background_image']){ ?>
  body.single.<?php echo $prefix; ?>-<?php echo $slug; ?> #content:before{
    content: '';
    position: fixed;
    z-index: -4;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-image: url('<?php echo $v; ?>');
    background-position: center;
    <?php if($v = @$c['theme_background_image_size']){ ?>
      background-size: <?php echo $v; ?>;
      <?php if($v == 'cover'){ ?>
      background-repeat: no-repeat;
      <?php } ?>
    <?php } ?>
  }
  <?php } ?>

  <?php if($v = @$c['theme_background_font_color_visibility']): ?>
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-font-color-escape,
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-font-color-escape:hover
    {
      color: <?php echo $v; ?>;
      fill: <?php echo $v; ?>;
    }
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-background-color-escape,
    *:not(body).<?php echo $prefix; ?>-<?php echo $slug; ?> .<?php echo $style_group; ?>-background-color-escape:hover
    {
      background-color: <?php echo $v; ?>;
    }
  <?php endif; ?>

<?php

  }
}
?>
</style>