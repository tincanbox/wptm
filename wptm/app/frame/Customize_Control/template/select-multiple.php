<label>
  <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
  <select <?php $this->link(); ?> multiple="multiple" style="height: 100%; width: 100%;">
  <?php

  $val = $this->value();
  $val = is_array($val) ? $val : array();

  foreach ( $this->choices as $value => $label ) {
    $selected = (in_array($value, $val)) ? selected( 1, 1, false ) : '';
    echo '<option value="'
      . esc_attr($value)
      . '"'. $selected . '>'
      . (is_object($label) ? $label->slug : $label) . '</option>';
  }

  ?>
  </select>
</label>

