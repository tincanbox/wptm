<?php


class WPTM_Comment_Form {


  private $post_id = null;
  private $commenter = null;
  private $user = null;
  private $default_fields = array();
  private $field_structure = array();
  private $field_config = array();


  function __construct(array $config = array()){
    $this->post_id = get_the_ID();
    $this->commenter = wp_get_current_commenter();
    $this->user = wp_get_current_user();
    $this->config = $config;
    add_filter('comment_form_fields', array($this, 'store_field_html') );
  }


  function set_field_config($field, $config = array()){
    $this->field_config[$field] = array_merge(array(

      'priority' => 0,
      'disabled' => false,

    ), (@$this->field_config[$field] ? $this->field_config[$field] : array()), $config);
  }


  function store_field_html($fields = array()){
    $this->field_structure = $this->build_field_structure($fields);
    return $this->sort_fields_priority();
  }


  function build_field_structure($fields){
    $data = array(0 => array());
    foreach($fields as $n => $f){
      $p = new stdClass;
      $p->name = $n;
      $p->html = $f;

      $oi = 0;
      if(isset($this->field_config[$n])){
        $c = $this->field_config[$n];
        if($c['priority']){
          $oi = (int)$c['priority'];
        }
        if(@$c['disabled']){
          continue;
        }
        if(@$c['param']){
          $p->html = WPTM::instance()->frame->vendor->mustache->render($p->html, $c['param']);
        }
      }

      # Grouping Priority.
      if(!@$data[$oi]){
        $data[$oi] = array();
      }
      $data[$oi][] = $p;
    }

    return $data;
  }


  function sort_fields_priority(){
    $export = array();
    foreach($this->field_structure as $priority => $group){
      foreach($group as $f){
        $export[$f->name] = $f->html;
      }
    }
    return $export;
  }


  function render(){
    @ob_start();
    comment_form($this->config['comment_form']);
    $html = ob_get_clean();
    WPTM::render('template/partial/comment/form', array(
      'user' => $this->user,
      'fields' => $this->default_fields,
      'html' => $html
    ));
  }

}
