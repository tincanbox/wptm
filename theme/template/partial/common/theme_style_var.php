<style>
:root {
  <?php foreach($theme_vars as $var => $val) { ?>
  --<?php echo str_replace('_', '-', $var); ?>: <?php echo $val; ?>;
  <?php } ?>
}
</style>
