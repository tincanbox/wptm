<style>
:root {
  --theme-spacing: 1.25rem;
  --theme-asset-url: '<?php echo get_bloginfo('template_directory'); ?>';
  <?php foreach($theme_vars as $var => $val) { ?>
  --<?php echo str_replace('_', '-', $var); ?>: <?php echo $val; ?>;
  <?php } ?>
}
</style>
