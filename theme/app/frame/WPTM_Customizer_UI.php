<?php

class WPTM_Customizer_UI {

  protected $section_id_list = array();
  protected $section_id_active = null;
  protected $panel_id_list = array();
  protected $panel_id_active = null;


  function __construct($parent, $conf = array()){
    $this->parent = $parent;
    $this->customizer = $this->parent->customizer;
  }


  function __call($n, $a){
    return call_user_func_array(array($this->parent, $n), $a);
  }


  function build($conf = array()){
    return new self($this, $conf);
  }


  function append(WPTM_Customizer_UI $ui){
    if($ui->section_id_active){
      $this->section($ui->section_id_active, array(
        'section' => $this->section_id_active,
        'panel'   => $this->panel_id_active
      ));
    }
  }


  function panel($name, $arg = array()){
    $this->panel_id_active = $name;
    if($this->panel_id_active && !in_array($this->panel_id_active, $this->panel_id_list)){
      $this->panel_id_list[] = $this->panel_id_active;
      $arg['title'] = @$arg['title'] ? $arg['title'] : ucfirst($name);
      if(@$this->parent->panel_id_active){
        $arg['panel'] = $this->parent->panel_id_active;
      }
      if(@$this->parent->section_id_active){
        $arg['section'] = $this->parent->section_id_active;
      }
      $this->add_panel($this->panel_id_active, $arg);
    }
    return $this;
  }


  function section($name, $arg = array()){
    $this->section_id_active = $name;
    if($this->section_id_active && !in_array($this->section_id_active, $this->section_id_list)){
      if(!@$arg['title']){
        $arg['title'] = ucfirst(__($this->section_id_active));
      }
      if(@$this->panel_id_active){
        $arg['panel'] = $this->panel_id_active;
      }
      if(@$this->parent->section_id_active){
        $arg['section'] = $this->parent->section_id_active;
      }
      $this->add_section($this->section_id_active, $arg);
    }
    return $this;
  }


  function control($type, $name, $arg = array(), $setting = array()){

    $s = $this->setting($name, $setting);

    if($s){
      $arg = array_merge(@$s['control'] ? $s['control'] : array(), $arg);
      $arg['section'] = $this->section_id_active;
      $arg['settings'] = $name;
      $arg['label'] = @$arg['label'] ? $arg['label'] : ucfirst(__($name));
      call_user_func_array(
        array($this, 'add_control'),
        $this->build_control_args($type, $name, $arg)
      );
    }else{
      throw new Exception(__CLASS__.': Undefined setting name "'.$name.'". Settings should be defined at `app/config/setting.php`.');
    }

    return $this;
  }


  function control_group($type, $gname, $grouped, $arg = array()){
    foreach($grouped as $name => $label){
      $this->control($type, $gname.'['.$name.']', array_merge($arg, array('label' => $label)));
    }
    return $this;
  }


  function build_control_args($type, $name, $arg){
    switch($type){
      case 'image':
        return array(new WP_Customize_Image_Control($this->customizer, $name, $arg));
      case 'upload':
        return array(new WP_Customize_Image_Control($this->customizer, $name, $arg));
      case 'color':
        return array(new WP_Customize_Color_Control($this->customizer, $name, $arg));
      case 'text':
        return array($name, $arg);
      default:
        $c = 'WPTM_Customize_Control_'.preg_replace_callback('@-([a-z])@', array($this, 'type2cname'), ucfirst($type));
        if(class_exists($c)){
          return array(new $c($this->customizer, $name, $arg));
        }else{
          $arg['type'] = $type;
          return array($name, $arg);
        }
    }
  }

  function type2cname($m){
    return '_'.strtoupper($m[1]);
  }

  function add_panel($s, $arg = array()){
    return $this->customizer->add_panel($s, $arg);
  }

  function add_section($s, $arg = array()){
    return $this->customizer->add_section($s, $arg);
  }

  function add_control($s, $arg = array()){
    return $this->customizer->add_control($s, $arg);
  }

}
