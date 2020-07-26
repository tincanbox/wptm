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
      <div id="content">
        <div class="container">
          <div class="row">
            <?php if( WPTM::option('sidebar_toggle') == 1){ ?>
              <?php if( WPTM::option('sidebar_align') == "left" ){ ?>
                <div class="col-md-3">
                  <?php WPTM::render('template/partial/common/sidebar'); ?>
                </div>
              <?php } ?>
              <div class="col-md-9">
                <?php @$hide_structure_navigation ? '' : WPTM::render('template/partial/common/structure_navigation', array(
                  'main_query' => $wp_query
                )); ?>
                <div id="yield">{{{ yield }}}</div>
                <div style="text-align: right;">
                  <a class="gototop theme-font-color-background-escape">
                    <span class="far fa-arrow-alt-circle-up">&#9650;</span> <span><?php echo __('Top'); ?></span>
                  </a>
                </div>
              </div>
              <?php if( WPTM::option('sidebar_align') == "right" ){ ?>
                <div class="col-md-3">
                  <?php WPTM::render('template/partial/common/sidebar'); ?>
                </div>
              <?php } ?>
            <?php }else{ ?>
              <div class="col-md-12">
                <?php @$hide_structure_navigation ? '' : WPTM::render('template/partial/common/structure_navigation', array(
                  'main_query' => $wp_query
                )); ?>
                <div id="yield">{{{ yield }}}</div>
                <div style="text-align: right;">
                  <a class="gototop theme-font-color-background-escape">
                    <span class="far fa-arrow-alt-circle-up">&#9650;</span> <span><?php echo __('Top'); ?></span>
                  </a>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php WPTM::render('template/partial/common/footer'); ?>
    </div>
    <?php wp_footer(); ?>
    <script src="<?php echo get_template_directory_uri(); ?>/asset/bootstrap.js"></script>
  </body>
</html>
