<?php

include dirname(__FILE__).'/WPTM_Factory.php';

class WPTM {


  # Configuration holder.
  private $__config = array();
  private $__cache = array(
    'config' => array(),
    'article_group' => array()
  );

  static private $instance_storage = array();
  static public $post_type_builtin_target = array('post', 'page');


  function __construct($conf = array()){
    $this->__config = array_merge_recursive(array(
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

    add_action('init', array($instance, 'init'));


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
      $p_ID = @$c->category_parent;
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

  static function show_404(){
    WPTM::instance()->frame->view->clear();
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    $v = WPTM::template('/404');
    echo $v;
    exit;
  }

  function init(){
    $this->setup_article_group();
    add_action('pre_get_posts', array($this, 'generate_search_condition'), 1);
  }


  #
  #
  #
  function _config($key = ''){
    if(!is_string($key)){
      trigger_error('$key must be a string.');
    }

    $cache = $this->_cache('config');
    if($cache && array_key_exists($key, $cache)){
      return $cache[$key];
    }

    $surr = $this->__config;

    foreach(explode('.', $key) as $n){
      if(array_key_exists($n, $surr)){
        $v = $surr[$n];
        if(is_array($v)){
          $surr = $v;
        }else{
          $this->__cache['config'][$key] = $v;
          return $v;
        }
      }else{
        return null;
      }
    }

    return $surr;
  }

  function _cache($k, $v = null){
    if(isset($v)){
      $this->__cache[$k] = $v;
      return $v;
    }
    if(is_admin()){
      return null;
    }
    if(is_customize_preview()){
      return null;
    }
    if(array_key_exists($k, $this->__cache)){
      return $this->__cache[$k];
    }
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
        $this->__config[$n] = $r;
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
    if (!WPTM::option('option_initialized')) {
      $s = $this->frame->customizer->init_theme_option();
    }
    add_action('customize_register', array($this->frame->customizer, 'register'));
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

  function setup_article_group(){
    if($v = $this->_cache('article_group')){
      return $v; 
    }
    $d = array();
    foreach(array('category', 'post_type', 'tag') as $type){
      $conf = WPTM::option($type);
      if(!$conf) continue;

      foreach($conf as $slug => $c){
        $content = array_merge(array(
          'slug' => $slug,
          'type' => $type
        ), $c);
        $o = null;
        switch($type){
          case "post_type":
            $o = get_post_type_object($slug);
            $content['link'] = get_post_type_archive_link($slug);
            $content['name'] = $o->labels->name;
          break;
          case "category":
            $o = get_category_by_slug($slug);
            $content['link'] = get_term_link($o);
            $content['name'] = $o->name;
          break;
          case "tag":
            $o = get_term_by('name', $slug, 'post_tag');
            $content['link'] = get_term_link($o);
            $content['name'] = $o->name;
          break;
        }
        $content['object'] = $o;
        $d[] = $content;
      }
    }

    $this->_cache('article_group', $d);

    return $d;
  }

  /**
   * @param [type] $menu
   * @param [type] $config
   * @return array
   */
  static function generate_menu_info($menu, $config): array
  {
    $o = [];
    $o['id'] = $menu->ID;
    $o['menu'] = $menu;
    $o['is_active'] = true;
    $o['title'] = $menu->title;
    $o['type'] = $menu->type;
    $o['url'] = $menu->url;
    $o['slug'] = null;
    $o['parent'] = null;
    $o['parent_id'] = null;
    $o['children'] = [];

    $pid = intval($menu->menu_item_parent);
    if ($pid) {
      $o['parent_id'] = $pid;
    }

    $override = [];
    switch($menu->type){
      case "taxonomy":
        $term = get_term_by("id", $menu->object_id, $menu->object);
        if(!$term){
          return false;
        }
        switch($menu->object){
          case "category":
          case "tag":
            if($c = @$config[$menu->object][$term->slug]){
              $override = $c;
            }
          break;
        }
        $override['slug'] = $term->slug;
        $override['type'] = $menu->object;
      break;
      case "post_type":
        if($c = @$config['post_type'][$menu->object]){
          $override = $c;
        }
        $o['slug'] = $menu->object;
      break;
      default:
        $o['slug'] = $menu->object;
      break;
    }

    return array_merge($o, $override);
  }

  static function get_menu_flatten($target = null)
  {
    $result = [];
    if ($target) {
      // recursive
      $tree = $target;
    } else {
      $tree = self::get_menu_tree();
    }

    foreach ($tree as $info) {
      if (count($info['children'])) {
        
      }
    }

    return $result;
  }

  /**
   * @return array
   */
  static function get_menu_tree(): array
  {
    $menu_item_list = wp_get_nav_menu_items("WPTM-DEFAULT");
    $config = WPTM::get_article_group_config(array('grouped' => true));
    $menu_ref = [];
    $result = [];

    // build all ref
    foreach($menu_item_list as $menu ){
      $info = self::generate_menu_info($menu, $config);
      if (!$info) {
        continue;
      }
      $menu_ref[$info['id']] = $info;
    }

    foreach ($menu_ref as $id => $info) {
      $pid = $info['parent_id'];
      if($pid && array_key_exists($pid, $menu_ref)){
        $info['parent'] =& $menu_ref[$pid];
        $menu_ref[$pid]['children'][$id] = $info;
      }
    }

    foreach ($menu_ref as $info) {
      if (!$info['parent_id']) {
        $result[] = $info;
      }
    }

    return $result;
  }

  static function get_article_group_config($opt = array()){
    $d = array();
    $opt_ordered = !!@$opt['ordered'];
    $opt_grouped = !!@$opt['grouped'];

    foreach(static::instance()->setup_article_group() as $ag){
      $type = $ag['type'];
      if($opt_ordered){
        $pri = (int)@$ag['display_priority'];
        $pri = $pri > 0 ? $pri : 999;
        if(@!$d[$pri]) $d[$pri] = array();
        if($opt_grouped){
          $d[$pri][$ag['type']][] = $ag;
        }else{
          $d[$pri][] = $ag;
        }
      }else{
        if($opt_grouped){
          if(@!$d[$type]) $d[$type] = array();
          $d[$type][$ag['slug']] = $ag;
        }else{
          $d[] = $ag;
        }
      }
    }

    ksort($d);
    return $d;
  }

  function generate_search_condition($query)
  {
    if(is_admin()){
      return $query;
    }

    if(@$query->is_generate_search_condition_done){
      return $query;
    }

    if(
         $query->is_home() || $query->is_page()
      || $query->is_single() || $query->is_archive() || $query->is_post_type_archive()
      || $query->is_date() || $query->is_year() || $query->is_month()
      || $query->is_category() || $query->is_tag() || $query->is_tax()
      || $query->is_author()
      || $query->is_search()
      || $query->is_feed()
      || $query->is_404()
    ){

    }else{
      return $query;
    }

    if($query->is_main_query()){
      // do something ??
    }

    $qq = $query->query;
    // Base conds
    $search = array();
    $exclude_cond = array();
    $include_cond = array();

    // builds string-based query.
    if(@$qq['s']){
      $qs = explode(" ", $qq['s']);
      $rm = array();
      while ($l = array_pop($qs)) {
        $cond = explode(":", $l);
        if (count($cond) > 1) {
          $search[$cond[0]] = $cond[1];
        } else {
          $rm[] = $l;
        }
      }
      $search['s'] = (count($rm)) ? join(" ", $rm) : "";
    }
    $conf = static::get_article_group_config(array('grouped' => true));

    // exclude: category
    if(@$conf['category']){
      $ls = array();
      foreach ($conf['category'] as $sl => $c) {
        $disable = false;
        if(!@$c['is_active']) $disable = true;
        if($query->is_search() && @$c['search_excluded']) $disable = true;
        if($disable) $ls[] = $c['object']->term_id;
      }
      $exclude_cond['category__not_in'] = $ls;
    }

    // exclude: tag
    if(@$conf['tag']){
      $ls = array();
      foreach ($conf['tag'] as $sl => $c) {
        $disable = false;
        if(!@$c['is_active']) $disable = true;
        if($query->is_search() && @$c['search_excluded']) $disable = true;
        if($disable) $ls[] = $c['object']->term_id;
      }
      $exclude_cond['tag__not_in'] = $ls;
    }

    // exclude: post_type

    $has_no_pt_needle = true;
    if(@$conf['post_type']){
      if(empty(@$qq['post_type'])){
        $include_cond['post_type'] = self::$post_type_builtin_target;
      }else{
        $has_no_pt_needle = false;
        $include_cond['post_type'] = is_array($qq['post_type']) ? $qq['post_type'] : array($qq['post_type']);
      }
      foreach ($conf['post_type'] as $c) {
        $disable = false;
        $disable =
            (@!$c['is_active'])
          || ($query->is_search() && @$c['search_excluded'])
          || (@$exclude_cond['post_type'] && in_array($c['slug'], $exclude_cond['post_type']))
        ;
        if($disable){
          if(($key = array_search($c['slug'], $include_cond['post_type'])) !== false){
            unset($include_cond['post_type'][$key]);
          }
        }else{
          // pushing confs
          if($has_no_pt_needle){
            $include_cond['post_type'][] = $c['slug'];
          }
        }
      }
      if(empty($include_cond['post_type'])){
        $include_cond['post_type'] = array("INVALID_POST_TYPE");
      }
      $include_cond['post_type'] = array_unique($include_cond['post_type']);
    }

    $result = array_merge_recursive($search, $include_cond, $exclude_cond);
    foreach($result as $k => $v){
      $query->set($k, $v);
    }

    // triggered twice....?
    $query->is_generate_search_condition_done = true;

    return $query;
  }



}
