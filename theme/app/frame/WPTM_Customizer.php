<?php

include_once(__DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, ['Mixin', 'Configurable.php']));

class WPTM_Customizer extends WPTM_Factory {

  const PROTECTED_SETTING_PREFIX = '__';

  const OPTION_SEPARATOR = '.';

  /** @var WPTM\Mixin\Configurable */
  private $_setting;
  /** @var WPTM\Mixin\Configurable */
  private $_option_cache;
  private $_group = [
    'post_type' => [],
    'category' => [],
    'tag' => [],
  ];

  /**
   * Undocumented function
   *
   * @return void
   */
  function init(){
    $this->_setting = new WPTM\Mixin\Configurable;
    $this->_option_cache = new WPTM\Mixin\Configurable;
    $this->init_setting();
    $this->init_group();
    $this->init_option();
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  function init_setting(){
    $default = ['default' => null];
    // Lazy Init
    if($this->_setting->is_empty()){
      $setting = $this->core->config('setting');
      foreach($setting as $name => $conf){
        if (self::is_protected_setting($name)) {
          $this->_setting->set($name, $conf);
        }else{
          $this->_setting->set($name, array_merge($default, $conf));
        }
      }
    }
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  function init_group(){
    $ps = get_post_types(array('_builtin' => false));
    $ps = array_merge(WPTM::$post_type_builtin_target, $ps);
    $this->_group['post_type'] = $ps;
    $this->_group['category'] = get_categories();
    $this->_group['tag'] = get_tags();
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  function init_option(){
    $settings = $this->setting();

    foreach ($settings as $option_name => $setting) {
      if (self::is_protected_setting($option_name)) {
        continue;
      }
      $this->_setting->set($name, $setting);
    }

    $mod = [];
    foreach ($this->_group as $k => $matches) {
      $group_name = $k;
      foreach ($matches as $m) {
        switch ($group_name) {
          case 'post_type':
            $identifier = $m;
            break;
          case 'category':
          case 'tag':
            $identifier = $m->slug;
            break;
          default:
            throw new \Exception('You can not have `'.$k.'` as group settings.');
        }

        $mod[$identifier] = @$mod[$identifier] ?: [];

        $default_setting = $this->setting(self::PROTECTED_SETTING_PREFIX . 'group');
        if (!is_array($default_setting)) {
          throw new \Exception('group settings should be in setting.php');
        }

        foreach ($default_setting as $option_name => $override) {
          $option_key = implode(self::OPTION_SEPARATOR, [$group_name, $identifier, $option_name]);
          $this->setting($option_key, $override);
        }

      }
    }
  }

  /**
   * Undocumented function
   *
   * @param [type] $name
   * @return void
   */
  function group($name){
    return $this->_group[$name];
  }

  /**
   * Undocumented function
   *
   * @param [type] $wp_customize
   * @return void
   */
  function register($wp_customize){

    include dirname(__FILE__).'/WPTM_Customizer_UI.php';
    foreach(glob(dirname(__FILE__).'/Customize_Control/*') as $f)
      is_file($f) && include_once $f;

    $this->customizer = $wp_customize;
    $this->setting();
    $this->UI = new WPTM_Customizer_UI($this);
    $this->core->hook('build_theme_customize', ['customizer' => $this]);
  }

  /**
   * Undocumented function
   *
   * @param [type] $k
   * @param [type] $override
   * @return mixed
   */
  function setting($name = null, $override = null){
    // Main Job
    if($name){
      // Only NON-protected settings
      if (!self::is_protected_setting($name)) {
        if(is_array($override)){
          $this->_setting->set($name, array_merge($this->_setting->get($name, []), $override));
        }

        // Init Flag
        if(!@$this->_setting->has([$name, self::PROTECTED_SETTING_PREFIX . 'initialized'])){
          $this->_setting->set([$name, self::PROTECTED_SETTING_PREFIX . 'initialized'], true);
          $this->option($name);
        }
      }

      if(@$this->customizer){
        $this->customizer->add_setting($name, $this->_setting->get($name));
      }

      return @$this->_setting->get($name);
    }

    return $this->_setting;
  }

  /**
   * Undocumented function
   *
   * @param [type] $name
   * @param [type] $value
   * @return void
   */
  function option($name = null, $value = null){
    $arg_length = func_num_args();
    if ($name == 'post_type.page.show_eyecatch') {
    }
    if($arg_length === 2){
      // SET
      $this->_option_cache->set($name, $value);
      set_theme_mod($name, $value);

      return $this->_option_cache->get($name);
    }else if ($arg_length === 1){
      // GET
      $c = $this->setting($name);
      $not_found_error = 'NOT_FOUND_ERROR';
      $v = get_theme_mod($name, $not_found_error);

      if(!@$this->_option_cache->has($name)){
        // set default if empty and default is not empty
        if($v === $not_found_error){
          if (array_key_exists('default', $c) && $c['default'] !== $v) {
            $v = $c['default'];
            set_theme_mod($name, $v);
          } else {
            $v = null;
          }
        }
        $this->_option_cache->set($name, $v);
      }

      return $this->_option_cache->get($name);
    } elseif($arg_length === 0) {
      // ALL
      return $this->_option_cache;
    }
  }

  /**
   * Helper
   *
   * @static
   * @param [type] $setting_name
   * @return boolean
   */
  static function is_protected_setting($setting_name){
    return preg_match('/^' . self::PROTECTED_SETTING_PREFIX . '/', $setting_name);
  }


}
