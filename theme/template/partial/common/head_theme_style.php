<link href='//fonts.googleapis.com/earlyaccess/notosansjapanese.css' rel='stylesheet' type='text/css'>

<style>
html,body {
  font-family: 'Lato', 'Noto Sans JP', "Montserrat","游ゴシック",YuGothic,"ヒラギノ角ゴ ProN W3","Hiragino Kaku Gothic ProN","メイリオ",Meiryo, -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  background-color: transparent;
}

#container::before {
  content: '';
  display: block;
  position: absolute;
  top: 0; right: 0; bottom: 0; left: 0;
  z-index: -1000; }

<?php if($v = @WPTM::option('theme_background_color')){ ?>
  #container::before {
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
#container {
  background-image: url('<?php echo $v; ?>');
  background-position: center;
  background-attachment: fixed;
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
  background-color: <?php echo $v; ?>
}
<?php } ?>
<?php
if($v = WPTM::option('theme_header_font_color')){ ?>
.theme-header-font-color,
.theme-header-font-color:hover {
  color: <?php echo $v; ?>
}
.theme-header-background-color-escape {
  background-color: <?php echo $v; ?>
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

.theme-category-icon {
  width: 1.1em;
  height: 1.1em;
  display: inline-block;
  background-size: contain;
  vertical-align: middle;
  background-position: center;
}
<?php

$conf = WPTM::option('category');

if($conf){
  foreach($conf as $slug => $c):
    ?>
    #content.category-<?php echo $slug; ?>::before {
      content: '';
      display: block;
      position: absolute;
      top: 0; right: 0; bottom: 0; left: 0;
      z-index: -999; }

    <?php if($v = @$c['theme_background_color']): ?>
      body.single #content.category-<?php echo $slug; ?>::before {
        background-color: <?php echo $v ?><?php
        if($v = @$c['theme_background_opacity']){
          echo str_pad(dechex(intval($v)), 2, "0", STR_PAD_LEFT);
        }
        ?>; }
      *:not(body).category-<?php echo $slug; ?> .category-font-color,
      *:not(body).category-<?php echo $slug; ?> .category-font-color:hover {
        color: <?php echo $c['theme_background_color']; ?>;
        fill: <?php echo $c['theme_background_color']; ?>;}
      *:not(body).category-<?php echo $slug; ?> .category-background-color {
        background-color: <?php echo $c['theme_background_color']; ?>;}
    <?php endif; ?>

    <?php if($v = @$c['theme_background_image']){ ?>
    body.single #content.category-<?php echo $slug; ?> {
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

    <?php if($v = @$c['theme_background_font_color_visibility']): ?>
      *:not(body).category-<?php echo $slug; ?> .category-font-color-escape,
      *:not(body).category-<?php echo $slug; ?> .category-font-color-escape:hover {
        color: <?php echo $v; ?>;
        fill: <?php echo $v; ?>;}
    <?php endif; ?>

  <?php endforeach; ?>
  <?php
}
?>
</style>