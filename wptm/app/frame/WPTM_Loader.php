<?php

class WPTM_Loader extends WPTM_Factory {

  #
  #
  function load($f, $args = array()){
    $d = $this->core->config('path.app');
    $p = $d.$f.'.php';
    if(is_file($p)){
      extract($args);
      return @include($p);
    }else{
      if(is_dir($d.$f)){
        $ret = array();
        foreach(glob($d.$f.'/*') as $p){
          $fn = basename($p, '.php');
          $ret[] = $this->load($f.'/'.$fn, $args);
        }
        return $ret;
      }
    }
    return false;
  }


  function enqueue_script($name, $req = array()){
    $ns = WPTM::config('namespace').'-script-'.$name;
    wp_register_script(
      $ns,
      get_template_directory_uri().'/asset/js/'.$name.'.js',
      $req, '', true );
    wp_enqueue_script($ns);
  }


}
