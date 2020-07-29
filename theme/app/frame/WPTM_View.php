<?php

class WPTM_View extends WPTM_Factory {

  public $variables = array();

  public $_wp_global = array();

  protected $wp_global_reference = array(
    "post",         # (WP_Post) The post object for the current post. Object described in Class_Reference/WP_Post.
    "authordata",   # (WP_User) The author object for the current post. Object described in Class_Reference/WP_User.
    "wp_query",     # (object) The global instance of the Class_Reference/WP_Query class.
    "wp_rewrite",   # (object) The global instance of the Class_Reference/WP_Rewrite class.
    "wp",           # (object) The global instance of the Class_Reference/WP class.
    "wpdb",         # (object) The global instance of the Class_Reference/wpdb class.
    "wp_locale",    # (object)
    "wp_admin_bar", # (WP_Admin_Bar)
    "wp_roles",     # (WP_Roles)
  );


  function initialize(){
    $this->meta = new stdClass;
  }


  function inherit($var = array()){
    return array_merge($this->variables, $var);
  }


  function assign($key, $val){
    $this->variables[$key] = $val;
  }


  function wp_global($k, $toggle = false){
    if(array_key_exists($k, $this->_wp_global)){
      $v = $this->_wp_global[$k];
      return $v;
    }else{
      return null;
    }
  }


  function snapshot($vars = array()){
    foreach($this->wp_global_reference as $k){
      if(isset($GLOBALS[$k])){
        $this->_wp_global[$k] = $GLOBALS[$k];
      }
    }
    foreach($vars as $n => $v){
      if(array_key_exists($n, $this->variables)){
        $this->variables[$n] = $v;
      }
    }
  }

  function clear(){
    while(ob_get_level() > 0) ob_end_clean();
  }

  function render($name, array $var = array(), $output = true, $inherit = false) {
    $buff = "";
    $oblv = ob_get_level();
    try {
      if(empty($this->_wp_global)){
        $this->snapshot();
      }

      if(is_array($name)){
        $set = array();
        foreach($name as $fname){
          $set[$fname] = $this->render($fname, $var, $output);
        }
        return $set;
      }else{
        $this->variables = $this->inherit($var);
        $f = $this->core->config('path.base').DIRECTORY_SEPARATOR.$name.'.php';

        ob_start();

        if(file_exists($f)){
          ($inherit)
            ? extract($this->variables)
            : extract($var);
          include($f);
        }else{
          echo __CLASS__.'::render > File not found. '.var_export($name, true);
        }
        $buff = ob_get_clean();
        while(ob_get_level() > $oblv) ob_end_clean();

        $template = $this->core->frame->vendor->connect('mustache');
        if($template){
          $buff = $template->render($buff, $inherit ? $this->variables : $var);
        }

        if($output){
          if($oblv == 0){
            print_r($buff);
          }else{
            print_r($buff);
          }
        }else{
          return $buff;
        }
      }
    }catch(\Error $e){
      while(ob_get_level() > $oblv) ob_end_clean();
      $buff = "";
    }

  }


}
