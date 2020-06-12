<?php

class WPTM_Admin extends WPTM_Factory {

  protected $admin_page_name = null;

  protected $pages = array(
  );


  function prepare(){

    $this->admin_page_name = $this->core->config('name').'_theme_setting';

    if(empty($this->pages)) return;

    add_menu_page(
      $this->core->config('name').' Settings',
      $this->core->config('name').' Setting',
      'manage_options', 
      $this->admin_page_name,
      WPTM_Proxy::bind(array($this, 'render'), array(array(
        'id' => 'home',
        'pages' => $this->pages
      )))
    );

    foreach($this->pages as $page){
      $this->add_page($page);
    }
  }


  function add_page($page){
    $id = $this->core->config('name').'_setting_'.$page['id'];
    add_submenu_page(
      $this->admin_page_name,
      __($page['title']),
      __($page['title']),
      'edit_theme_options',
      $id,
      WPTM_Proxy::bind(array($this, 'render'), array($page))
    );
  }


  function render($s, $page){
    $this->update();
    $this->core->frame->view->render('template/page/admin/layout', array(
      'yield' => $this->core->frame->view->render('template/page/admin/'.$page['id'], array(
        'title' => @$page['title'] ? $page['title'] : $this->core->config('name')
      ), false)
    ));
  }

  function update(){
    if($data = $_POST){
    }
  }


}
