<?php

global $wp_query;
if($q = $this->wp_global('wp_query')){
  $wp_query = $q;
}

if( WPTM::option('basis_maintenance') == 1){
  $k = WPTM::option('basis_maintenance_secret_key');
  if(WPTM::option('basis_maintenance_secret_value') != @$_GET[$k] ){
    WPTM::render('template/page/maintenance');
    exit();
  }
}

?><html style="margin-top:0 !important;">
  <head>
  <?php wp_head(); ?>
  <?php WPTM::render('template/partial/common/head'); ?>
  </head>
  <body <?php body_class(); ?>>
    <div id="container">
      <?php WPTM::render('template/partial/common/header'); ?>
      <?php WPTM::render('template/partial/common/jumbotron'); ?>
      <div id="content" <?php body_class(); ?>>
        <div id="inner" class="container">
          <div class="row align-middle">
            <?php
            $show_sidebar = ( WPTM::option('sidebar_toggle') == 1);
            $col_main = 12;
            $col_side = 0;
            if($show_sidebar){
              $col_main = 9;
              $col_side = 3;
            }
            ?>
            <?php if( $col_side && WPTM::option('sidebar_align') == "left" ){ ?>
              <div class="col-md-<?php echo $col_side; ?>">
                <?php WPTM::render('template/partial/common/sidebar'); ?>
              </div>
            <?php } ?>
            <div class="col-md-<?php echo $col_main; ?>">
              <?php @$hide_structure_navigation ? '' : WPTM::render('template/partial/common/structure_navigation', array(
                'main_query' => $wp_query
              )); ?>
              <div id="yield">{{{ yield }}}</div>
              <div class="d-flex">
                <span class="gototop d-flex align-right theme-font-color-escape animatable attractive">
                  <div class="theme-font-color-escape center mr-1" style="width:1rem; height:1rem;">
                    <svg id="svg" viewBox="0 0 512 512"><use xlink:href="#chevron-up"></use></svg>
                  </div>
                  <span class="center"><?php echo __('TOP'); ?></span>
                </span>
              </div>
            </div>
            <?php if( $col_side && WPTM::option('sidebar_align') == "right" ){ ?>
              <div class="col-md-<?php echo $col_side; ?>">
                <?php WPTM::render('template/partial/common/sidebar'); ?>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php WPTM::render('template/partial/common/footer'); ?>
    </div>
    <?php wp_footer(); ?>
    <?php WPTM::render('template/partial/common/icon'); ?>
    <script src="<?php echo get_template_directory_uri(); ?>/asset/bootstrap.js"></script>
  </body>
</html>
