<?php

class WPTM_Customize_Control extends WP_Customize_Control {

  function __render(){
    $t = dirname(__FILE__).'/template/'.$this->type.'.php';
    (file_exists($t)) && include($t);
  }

}
