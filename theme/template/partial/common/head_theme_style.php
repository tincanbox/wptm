<link href='//fonts.googleapis.com/earlyaccess/notosansjapanese.css' rel='stylesheet' type='text/css'>
<style>

#container {
  background-color: <?php echo WPTM::option('theme_background_color'); ?>;
}

<?php if($v = WPTM::option('theme_background_image')){ ?>
body:not(.single) #container {
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

  <?php if($v = WPTM::option('theme_background_image_mask_opacity')){ ?>
  body:not(.single) #content {
    position: relative;
  }
  body:not(.single) #content::before {
    content: '';
    display: block;
    position: absolute;
    top: 0; right: 0; bottom: 0; left: 0;
    background-color: rgba(<?php echo WPTM::option('theme_background_image_mask_colorhex'); ?>, .<?php echo $v; ?>);
  }
  <?php } ?>
<?php } ?>

<?php # Header
if($v = WPTM::option('theme_header_background_color')){ ?>
.wptm-header-background-color {
  background-color: <?php echo $v; ?>
}
<?php } ?>

<?php # Header
if($v = WPTM::option('theme_header_font_color')){ ?>
.wptm-header-font-color {
  color: <?php echo $v; ?>
}
.wptm-header-background-color-escape {
  background-color: <?php echo $v; ?>
}
<?php } ?>
<?php
# Footer
if($v = WPTM::option('theme_footer_background_color')){ ?>
.wptm-footer-background-color {
  background-color: <?php echo $v; ?>;
}
.wptm-footer-font-color, .wptm-theme-footer-font-color * {
  color:  <?php echo WPTM::option('theme_footer_font_color'); ?>
}
<?php } ?>

<?php
# Background
if($v = WPTM::option('theme_background_font_color_visibility')){ ?>
.theme-font-color {
  color: <?php echo $v; ?>;
}
a.theme-font-color:hover {
  opacity: .75;
  text-decoration: underline;
}
<?php } ?>

.wptm-category-icon {
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
  foreach($conf as $slug => $c){ ?>
.category-<?php echo $slug; ?> .category-font-color-escape { color: <?php echo $c['escape-color']; ?>; }
.category-<?php echo $slug; ?> .category-font-color { color: <?php echo $c['theme-color']; ?>; }
.category-<?php echo $slug; ?> .category-background-color { background-color: <?php echo $c['theme-color']; ?>; }
    <?php
  }
}
?>
</style>