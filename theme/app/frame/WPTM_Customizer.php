<?php

class WPTM_Customizer extends WPTM_Factory {


  private $_setting = array();


  function register($wp_customize){

    include dirname(__FILE__).'/WPTM_Customizer_UI.php';
    foreach(glob(dirname(__FILE__).'/Customize_Control/*') as $f)
      is_file($f) && include_once $f;

    $this->customizer = $wp_customize;
    $this->setting();
    $this->UI = new WPTM_Customizer_UI($this);
    $this->core->build_theme_customize($this);
  }


  function setting($k = null, $override = null){
    $default = array('default' => null);

    if(empty($this->_setting)){
      $setting = $this->core->config('setting');
      foreach($setting as $name => $conf){
        $this->_setting[$name] = array_merge($default, $conf);
      }
    }

    if($k){
      if(!@$this->_setting[$k]){
        $this->_setting[$k] = array_merge($default);
      }
      if(is_array($override)){
        $this->_setting[$k] = array_merge($this->_setting[$k], $override);
      }
      if(@$this->customizer){
        $this->customizer->add_setting($k, $this->_setting[$k]);
      }
      return @$this->_setting[$k];
    }

    return $this->_setting;
  }


  function option($name, $value = null){
    $c = $this->setting($name);
    $pn = $name;
    if($value){
      return set_theme_mod($pn, $value);
    }else{
      return get_theme_mod($pn, $c ? @$c['default'] : null);
    }
  }


}
