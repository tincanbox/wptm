<?php

class WPTM_Factory {

  function __construct($core = null){
    $this->core = $core;
    if(method_exists($this, 'initialize')){
      $this->initialize();
    }
  }

}
