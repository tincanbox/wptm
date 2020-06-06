<?php

class WPTM_Customize_Control_Select_Multiple extends WPTM_Customize_Control {

  public $type = 'select-multiple';

  public function render_content(){
    if(empty($this->choices)) return;
    $this->__render();
  }

}
