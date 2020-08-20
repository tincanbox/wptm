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
<link rel="icon" href="/wp-content/themes/wptm/static/image/icon.png">

<meta name="keyword" content="<?php echo implode(',', $keywords); ?>">
<meta name="description" content="<?php echo get_bloginfo('description'); echo $description; ?>">

<script src="<?php echo get_bloginfo('template_directory'); ?>/static/vendor/jquery/jquery-1.12.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/static/vendor/bootstrap/css/bootstrap.min.css'; ?>">
<script src="<?php echo get_bloginfo('template_directory'); ?>/static/vendor/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/static/vendor/font-awesome/css/all.min.css'; ?>">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />

<?php WPTM::render('template/partial/common/share/prepare_facebook'); ?>
<?php WPTM::render('template/partial/common/share/prepare_twitter'); ?>
<?php WPTM::render('template/partial/common/share/prepare_line'); ?>


<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/asset/bootstrap.css?nc=<?php echo time() ;?>'; ?>">

<?php WPTM::render('template/partial/common/head_theme_style'); ?>
