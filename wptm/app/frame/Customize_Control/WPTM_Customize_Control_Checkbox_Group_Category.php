<?php

class WPTM_Customize_Control_Checkbox_Group_Category extends WPTM_Customize_Control {

  public $type = 'checkbox-group-category';

  public function render_content(){
    if(empty($this->choices)) return;
    $this->__render();
  }

}
