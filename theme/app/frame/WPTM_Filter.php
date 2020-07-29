<?php

class WPTM_Filter extends WPTM_Factory {


  # template_include
  #
  #
  static function template_include($path){
    $bd = WPTM::config('path.base');
    $td = WPTM::config('path.theme');
    $fn = str_replace($td, '', $path);
    $fn = $fn ? $fn : 'index.php';

    if(file_exists($path)){
      return $path;
    }

    foreach(WPTM::config('theme.include') as $tm){
      $f = $td . DIRECTORY_SEPARATOR . $tm . DIRECTORY_SEPARATOR . $fn;
      if(file_exists($f)){
        return $f;
      }
    }

    return $path;
  }


  #
  #
  #
  static function template_directory($a){
    return $a;
  }


  #
  #
  #
  static function template_directory_theme($path, $subtheme){
    $d = WPTM::config('path.theme');
    $sd = $d.$subtheme.DIRECTORY_SEPARATOR;
    $f = $sd.'functions.php';
    (file_exists($f)) && require_once($f);
    return $sd;
  }


  static function generate_css_class($opt = array()){
    global $wp_query;
    $qq = $wp_query;
    $classes = array();
    if(@$opt['post']){
      $cats = get_the_category();
      if(is_array($cats)){
        foreach($cats as $c){
          $ps = WPTM::get_category_parents($c->cat_ID);
          if($ps){
            foreach($ps as $p){
              $classes[] = 'category-'.$p->slug;
            }
          }
          $classes[] = 'category-'.$c->slug;
        }
      }
      $tags = get_the_tags();
      if(is_array($tags)){
        foreach($tags as $t){
          $classes[] = 'tag-'.$t->slug;
        }
      }
      $posttype = get_post_type();
      if($posttype){
        $classes[] = 'posttype-'.$posttype;
      }
    }else{
      $q = $qq->query;
      if(@$q['cat']){
        $c = get_the_category_by_id($q['cat']);
        $classes[] = $c->slug;
      }
      if(@$q['post_type']){
        var_dump($q['post_type']);
        $classes[] = 'posttype-'.$q['post_type'];
      }
    }
    return $classes;
  }


  static function post_class($classes){
    global $post;
    return array_merge($classes, self::generate_css_class(array(
      'post' => $post
    )));
  }


  static function body_class($classes = array()){
    if(in_array('single-post', $classes)){
    }
    return array_merge($classes, self::generate_css_class());
  }

}
