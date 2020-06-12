<div id="header" class="header navbar navbar-fixed-top navbar-default">
  <div class="container">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

    <div class="navbar-header">
      <a class="navbar-brand" href="<?php bloginfo('url'); ?>">
        <img alt="logo" src="<?php echo WPTM::option('logo'); ?>">
      </a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a
            href="#"
            class="dropdown-toggle"
            data-toggle="dropdown"
            role="button"
            aria-haspopup="true"
            aria-expanded="false"><span class="text">コンテンツ</span> <span class="caret"></span></a>

          <ul class="dropdown-menu">
            <?php

            $cats = WPTM::option('category_for_article_manage');
            $conf = WPTM::option('category');

            if($cats){
              $d = array();
              foreach($cats as $slug => $b){
                if($b && isset($conf[$slug])){
                  $c = $conf[$slug];
                  $p = (int)$c['display_priority'];
                  if(!@$d[$p]){
                    $d[$p] = array();
                  }
                  $d[$p][] = array_merge(array('slug' => $slug), $c);
                }
              }

              ksort($d);

              foreach($d as $priority => $g){
                foreach($g as $cat){
                  $c = get_category_by_slug($cat['slug']);
                  if($c){
                    ?><li class="category-<?php echo $c->slug; ?>">
                      <a href="<?php echo get_category_link($c->cat_ID); ?>">
                        <span class="text"><?php echo $c->name; ?></span></a>
                    </li><?php
                  }
                }
              }

            }
            ?>
            <?php
            $ms = WPTM::option('category_for_global_menu');
            if(count($ms)){

              $cats = array();
              foreach($ms as $slug => $b){
                if($b){
                  $cats[] = $slug;
                }
              }

              if($cats){
                ?>
                <li role="separator" class="divider"></li>
                <?php

                foreach($cats as $c){
                  $c = get_category_by_slug($c);
                  if($c){
                    ?><li class="category-<?php echo $c->slug; ?>">
                      <a href="<?php echo get_category_link($c->cat_ID); ?>">
                        <span class="text"><?php echo $c->name; ?></span></a>
                    </li><?php
                  }
                }

              }
              ?>
            <?php } ?>
          </ul>
        </li>

        <li class="hidden-sm">
          <form class="navbar-form navbar-left" role="search" action="<?php echo home_url('/'); ?>" style="margin-right: 0; margin-left: 0;">
            <div class="form-group">
            <div class="input-group">
              <!--<span class="input-group-addon"><i class="fa fa-user"></i></span>-->
              <input type="text" name="s" class="form-control" placeholder="<?php echo __('Search'); ?>">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-default">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
              </span>
            </div>
            </div>
          </form>
        </li>

        <li class="visible-sm">
          <a href="<?php echo home_url('/?s'); ?>">&nbsp;<i class="fa fa-search"></i>&nbsp;</a>
        </li>

      </ul>

    </div><!-- /.navbar-collapse -->
  </div>
</div>
