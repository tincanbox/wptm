<label>
  <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
  <?php

  foreach ( $this->choices as $category ) {
    $checked = $this->value() ? selected( 1, 1, false ) : '';
    ?><label><input type="checkbox" <?php echo preg_replace("@\"$@", '['.$category->slug.']"', $this->get_link()); ?> value="<?php echo $category->slug; ?>" <?php echo $checked; ?>/>
    <?php echo $category->name; ?></label><?php

  }

  ?>
</label>

