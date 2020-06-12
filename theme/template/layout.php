<?php

global $wp_query;
if($q = $this->wp_global('wp_query')){
  $wp_query = $q;
}

?><html>
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
              <div class="col-md-9">
                <?php @$hide_structure_navigation ? '' : WPTM::render('template/partial/common/structure_navigation', array(
                  'main_query' => $wp_query
                )); ?>
                <div id="yield">{{{ yield }}}</div>
                <div style="text-align: right;">
                  <a class="gototop theme-font-color-background-escape"><i class="glyphicon glyphicon-arrow-up"></i> トップへ戻る</a>
                </div>
              </div>
              <div class="col-md-3">
                <?php WPTM::render('template/partial/common/sidebar'); ?>
              </div>
            <?php }else{ ?>
              <div class="col-md-12">
                <?php @$hide_structure_navigation ? '' : WPTM::render('template/partial/common/structure_navigation', array(
                  'main_query' => $wp_query
                )); ?>
                <div id="yield">{{{ yield }}}</div>
                <div style="text-align: right;">
                  <a class="gototop theme-font-color-background-escape"><i class="glyphicon glyphicon-arrow-up"></i> トップへ戻る</a>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php WPTM::render('template/partial/common/footer'); ?>
    </div>
    <?php wp_footer(); ?>
    <script src="<?php echo get_template_directory_uri(); ?>/asset/script/main.js"></script>
  </body>
</html>
