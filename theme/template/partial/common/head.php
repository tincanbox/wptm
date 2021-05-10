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

<script src="<?php echo get_bloginfo('template_directory'); ?>/static/vendor/jquery/jquery-1.12.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/static/vendor/bootstrap/css/bootstrap.min.css'; ?>">
<script src="<?php echo get_bloginfo('template_directory'); ?>/static/vendor/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/static/vendor/font-awesome/css/font-awesome.min.css'; ?>">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />

<?php WPTM::render('template/partial/common/share/prepare_facebook'); ?>
<?php WPTM::render('template/partial/common/share/prepare_twitter'); ?>
<?php WPTM::render('template/partial/common/share/prepare_line'); ?>

<?php

$vars = [];
foreach([
  'theme_background_color',
  'theme_background_opacity',
  'theme_background_font_color_visibility',
  'theme_background_image',
  'theme_background_image_size',
  'theme_header_background_color',
  'theme_header_background_initial_opacity',
  'theme_header_background_stable_opacity',
  'theme_header_font_color',
  'theme_footer_font_color',
  'theme_footer_background_color',
  //
  'font_primary_url',
  'font_primary_name',
] as $var => $val){
  if (is_int($var)) {
    $var = $val;
    $val = null;
  }
  if ($val !== null) {
    if (is_callable($val)) {
      $$vars[$var] = $val(@WPTM::option($var));
    } else {
      $vars[$var] = $val;
    }
  } else {
    $vars[$var] = @WPTM::option($var);
  }
}
?>

<?php WPTM::render('template/partial/common/theme_style_var', ['theme_vars' => $vars]); ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory').'/asset/bootstrap.css'; ?>">
<?php WPTM::render('template/partial/common/theme_style_override', ['theme_vars' => $vars]); ?>
