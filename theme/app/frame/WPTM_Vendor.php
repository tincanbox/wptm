<?php

class WPTM_Vendor extends WPTM_Factory {

  static $vendor = array();


  function connect($name, $alias = null){

    $alias = (empty($alias)) ? $name : $alias;

    if(array_key_exists($alias, self::$vendor)){
      return self::$vendor[$alias];
    }else{
      $apppath = $this->core->config('path.app');

      $vendor_dir = $apppath . 'vendor/';
      $adaptor_dir = $vendor_dir . '@adaptor/';
      $adaptor_file = $adaptor_dir . $name . '.php';

      if(file_exists($adaptor_file)){
        $vendor = $vendor_dir.$name.DIRECTORY_SEPARATOR;
        $adaptor = $adaptor_dir;
        self::$vendor[$alias] = include_once($adaptor_file);
      }
    }
  }


}
