<?php

include dirname(__FILE__).'/WPTM_Factory.php';

class WPTM {


  # Configuration holder.
  private $config = array();
  private $cache = array(
    'config' => array()
  );

  static private $instance_storage = array();


  function __construct($conf = array()){
    $this->config = array_merge_recursive(array(
      'name'      => 'WPTM',
      'namespace' => ''
    ), $conf);

    $this->frame = new stdClass;
  }


  function __call($f, $arg = array()){
    if(@$this){
      if(method_exists($this, '_'.$f)){
        return call_user_func_array(array($this, '_'.$f), $arg);
      }
    }
    return null;
  }


  # setup :: Array -> Object
  #
  static function setup(array $config = array()){

    $instance = new self($config);
    self::$instance_storage[] = $instance;

    spl_autoload_register(array($instance, 'autoload'));

    # Load frames.
    foreach(array('view', 'admin', 'loader', 'vendor', 'filter', 'customizer') as $frame){
      $n = 'WPTM_'.ucfirst($frame);
      $i = new $n($instance);
      $instance->frame->{$frame} = $i;
    }

    if(!empty($config['preload'])){
      $instance->preload($config['preload']);
    }

    $instance->prepare_config();
    $instance->prepare_filter();
    $instance->prepare_theme_support();
    $instance->prepare_admin_menu();
    $instance->prepare_theme_customize();
    $instance->prepare_subtheme();
    $instance->prepare_customizer();
    $instance->prepare_editor();

    add_action('init', array($instance, 'prepare_user_meta'));
    add_action('init', array($instance, 'prepare_post_type'));
    add_action('init', array($instance, 'prepare_route'));

    return $instance;
  }


  static function instance($n = 0){
    if(count(self::$instance_storage)){
      if(isset(self::$instance_storage[$n])){
        return self::$instance_storage[$n];
      }else{
        throw new Exception(__CLASS__.'::'.__FUNCTION__.' -> Out of range '.$n);
      }
    }else{
      throw new Exception(__CLASS__.'::'.__FUNCTION__.' -> Instance not found.');
    }
  }


  static function config($key){
    return self::instance()->_config($key);
  }


  #
  #
  static function option($name, $value = null){
    $c = self::instance()->frame->customizer;
    return $c->option($name, $value);
  }

  #
  #
  static function render($name, $variables = array(), $output = true, $inherit = false){
    WPTM::instance()->frame->view->render($name, $variables, $output, $inherit);
  }

  #
  #
  static function template($name, $variables = array(), $inherit = true){
    return WPTM::instance()->frame->view->render($name, $variables, false, $inherit);
  }

  #
  #
  static function get_category_parents($cat_ID){
    $c = get_category($cat_ID);
    $r = array();
    if($c){
      $p_ID = $c->category_parent;
      if($p_ID){
        $p = get_category($p_ID);
        if($p){
          $r[] = $p;
          $pp = self::get_category_parents($p_ID);
          if($pp){ foreach($pp as $ppe) array_unshift($r, $ppe); };
        }
      }
    }
    return $r;
  }




  #
  #
  #
  function _config($key = ''){
    if(!is_string($key)){
      trigger_error('$key must be a string.');
    }

    if(array_key_exists($key, $this->cache['config'])){
      return $this->cache['config'][$key];
    }

    $surr = $this->config;

    foreach(explode('.', $key) as $n){
      if(array_key_exists($n, $surr)){
        $v = $surr[$n];
        if(is_array($v)){
          $surr = $v;
        }else{
          $this->cache['config'][$key] = $v;
          return $v;
        }
      }else{
        return null;
      }
    }

    return $surr;
  }


  # autoload :: String -> Nothing
  #
  # Frame Autoloader
  #
  function autoload($class){
    $app  = $this->config('path.app');
    $ns   = $this->config('namespace');
    $incl = $ns && strpos($class, $ns) !== false;
    $rmvd = ($incl ? str_replace($ns.'\\', '', $class) : $class);
    $appd = ($ns && !$incl ? $ns.'\\'.$class : $class);
    $part = explode('_', str_replace($this->config('name').'_', '', $rmvd));
    $part[] = null;
    $subdir = '';
    foreach($part as $p){
      if(!class_exists($appd)){
        $path = $app.'frame'.DIRECTORY_SEPARATOR . $subdir . $rmvd . '.php';
        if(!file_exists($path)){
          if($p){
            $subdir .= $p.DIRECTORY_SEPARATOR;
          }
          continue;
        }
        include_once($path);
        if(!$incl && $appd !== $class){
          class_alias($appd, $class);
        }
        return;
      }
    }
  }


  # preload :: Array -> Nothing
  #
  #
  function preload($preload_list = array(), $args = array()){
    foreach($preload_list as $d => $c){
      if(!is_array($c)) $c = array($c);
      foreach($c as $f){
        $this->frame->loader->load($d.'/'.$f);
      }
    }
  }


  function hook($name, $args = array()){
    return $this->frame->loader->load('hook/'.$name, $args);
  }


  #
  #
  #
  function prepare_config(){
    foreach(glob($this->config('path.app').'/config/*') as $c){
      $r = include_once($c);
      $n = str_replace('.php', '', basename($c));
      if(is_array($r)){
        $this->config[$n] = $r;
      }
    }
  }


  function prepare_editor(){
    $this->frame->loader->load('hook/prepare_tinymce');
  }


  #
  #
  #
  function prepare_filter(){
    $filter = $this->config('filter');
    foreach($filter as $f){
      add_filter($f[0], WPTM_Proxy::bind($f[1], @$f[2] ? $f[2] : array()));
    }
    add_filter('template_directory', WPTM_Proxy::bind('WPTM_Filter::template_directory'));
    add_filter('template_include', WPTM_Proxy::bind('WPTM_Filter::template_include'));
  }


  function prepare_theme_support(){
    $c = $this->config('theme_support');
    if($c){
      foreach($c as $n => $a){
        call_user_func_array('add_theme_support', is_array($a) ? $a : array($a));
      }
    }
  }


  function prepare_post_type(){
    $c = $this->config('post_type');
    if($c){
      foreach($c as $n => $a){
        $def = array(
          'public' => true,
          'has_archive' => true,
          'menu_position' => 5,
          'publicly_queryable' => true,
          'show_ui' => true,
          'taxonomies' => array('category', 'post_tag'),
          'rewrite' => true,
          'supports' => array(
            'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks',
            'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats',
          ),
        );

        if($n === 'post'){
        }else{
          $o = array_merge($def, is_array($a) ? $a : array($a));
          if(@$o['taxonomies']){
            foreach($o['taxonomies'] as $t){
              register_taxonomy_for_object_type($t, $n);
            }
          }
          call_user_func_array('register_post_type', array($n, $o));
        }
      }
    }
  }


  #
  #
  #
  function prepare_subtheme(){
    $d = $this->config('path.theme');
    foreach($this->config('theme.include') as $tm){
      $f = $d.$tm.DIRECTORY_SEPARATOR.'functions.php';
      if(file_exists($f)){
        add_filter('template_directory', WPTM_Proxy::bind('WPTM_Filter::template_directory_theme', array($tm)));
        include_once($f);
      }
    }
  }


  function prepare_theme_customize(){
    add_action('customize_register', array($this->frame->customizer, 'register'));
  }

  function build_theme_customize($customizer){
    $this->hook(__FUNCTION__, array('customizer' => $customizer));
  }


  function prepare_user_meta(){
    $config = $this->config('user_meta');
    foreach(get_users() as $user){
      foreach($config as $username => $c){
        if($user->data->user_login !== $username) continue;
        foreach($c as $k => $v){
          ($v) && update_user_meta($user->ID, $k, $v);
        }
      }
    }
  }

  function prepare_admin_menu(){
    // This tells WordPress to call the function named "setup_theme_admin_menus"
    // when it's time to create the menu pages.
    add_action("admin_menu", array($this->frame->admin, 'prepare'));
  }

  function prepare_route(){
    $routes = $this->config('route');
    foreach($routes as $regex => $prop){

      if(!@$prop['page']) continue;

      $params = array();
      if($p = @$prop['param']){
        foreach($p as $pk => $pm){
          $params[] = $pk.'='.$pm;
        }
      }

      $page_file = 'page/'.$prop['page'].'.php';

      $already = get_posts(array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => $page_file
      ));

      if(empty($already)){
        if(@$prop['post']['post_type']) unset($prop['post']['post_type']);
        if(@$prop['post']['page_template']) unset($prop['post']['page_template']);
        $p = array_merge(array(
          'post_title' => '',
          'post_content' => '',
          'post_status' => 'publish',
          'post_type' => 'page',
          'page_template' => $page_file
        ), @$prop['post'] ? $prop['post'] : array());
        wp_insert_post($p);

        $already = get_posts(array(
          'post_type' => 'page',
          'meta_key' => '_wp_page_template',
          'meta_value' => $page_file
        ));
      }


      add_rewrite_rule(
          $regex,
          ($page_file).'?'.implode('&', $params),
          @$prop['overwrite'] === false ? 'bottom' : 'top');
      add_filter('query_vars', WPTM_Proxy::bind(array($this, 'prepare_route_query_var'), array($prop)));
    }
  }

  function prepare_route_query_var($q, $prop = array()){
    $qv = @$prop['query_vars'];
    $q = $qv ? array_merge($q, $qv) : $q;
    return $q;
  }


}
