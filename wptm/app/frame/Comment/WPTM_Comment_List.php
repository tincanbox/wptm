<?php

class WPTM_Comment_List {


  private $parameter = array();


  function __construct($p){
    $this->parameter = $p;
  }


  function render(){
    wp_list_comments($this->parameter);
  }


}
