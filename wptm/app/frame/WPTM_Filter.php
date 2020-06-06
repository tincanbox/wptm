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


  static function post_class($classes){
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

    return $classes;
  }


  static function body_class($classes = array()){
    if(in_array('single-post', $classes)){
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
    }
    return $classes;
  }

}
