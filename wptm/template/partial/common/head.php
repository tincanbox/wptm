<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<title><?php

$main_query = $this->variables['main_query'];
$post = null;

bloginfo('name');

if(is_home()){
  echo ' - ';
  bloginfo('description');
}else{
  if($main_query->is_single()){
    if($p = $main_query->get_posts()){
      $post = $p[0];
      echo ' | ';
      echo $post->post_title;
    }
  }else{
  }
}

?></title>
<?php

$keywords = array(get_bloginfo('name'));
$description = '';

if($post){
  $description .= ': ';
  $description .= $post->post_title;
  $description .= '. ';
  $description .= $post->post_excerpt;
  $cats = get_the_category();
  foreach($cats as $c){
    $keywords[] = $c->slug;
  }
  $tags = get_the_tags();
  if($tags){
    foreach($tags as $t){
      $keywords[] = $t->slug;
    }
  }
}

?>
<meta name="keyword" content="<?php echo implode(',', $keywords); ?>">
<meta name="description" content="<?php echo get_bloginfo('description'); echo $description; ?>">

<script src="<?php echo get_bloginfo('template_directory'); ?>/asset/lib/vendor/jquery/jquery-1.12.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/asset/lib/bootstrap/css/bootstrap.min.css'; ?>">
<script src="<?php echo get_bloginfo('template_directory'); ?>/asset/lib/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/asset/lib/font-awesome/css/font-awesome.min.css'; ?>">

<?php WPTM::render('template/partial/common/share/prepare_facebook'); ?>
<?php WPTM::render('template/partial/common/share/prepare_twitter'); ?>
<?php WPTM::render('template/partial/common/share/prepare_line'); ?>


<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/asset/css/base.css'; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/asset/css/theme/default.css'; ?>">

<!--SASS4経由のCSS生成が不慣れのためプレーンCSSを読み込み-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/asset/css/theme/additional_plain_css.css'; ?>">-->

<?php WPTM::render('template/partial/common/head_theme_style'); ?>
