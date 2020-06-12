<link href='http://fonts.googleapis.com/earlyaccess/notosansjapanese.css' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
<style>

body {
font-family: 'Ubuntu', 'Noto Sans Japanese';
font-weight: 200;
letter-spacing: .02em;
}

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

<?php if($v = WPTM::option('theme_footer_background_color')){ ?>
#footer {
  background-color: <?php echo $v; ?>;
}
<?php } ?>

<?php if($v = WPTM::option('theme_background_font_color_visibility')){ ?>
.theme-font-color-background-escape {
  color: <?php echo $v; ?>;
}
a.theme-font-color-background-escape:hover {
  color: <?php echo $v; ?>;
  text-decoration: underline;
}
<?php } ?>

</style>
