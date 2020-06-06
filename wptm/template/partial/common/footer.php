<div id="footer">

  <div class="container">
    <div class="col-md-4">
      <p class="caption">コンテンツ</p>
      <ul class="">
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
              ?><li class="category-<?php echo $c->slug; ?>"><a href="<?php echo get_category_link($c->cat_ID); ?>"><?php echo $c->name; ?></a></li><?php
            }
          }
        }
      }

      ?>
      </ul>
    </div>

    <div class="col-md-4">
      <p class="caption">Section 001</p>
      <ul>
      <li><a class="link" href="" >ご利用ガイド</a></li>
      <li><a class="link" href="" >会員登録</a></li>
      </ul>
    </div>

    <div class="col-md-4">
      <p class="caption">サポート</p>
      <ul>
      <li><a class="link" href="">はじめての方へ</a></li>
      <li><a class="link" href="">会社概要</a></li>
      <li><a class="link" href="">特定商取引に関する表記</a></li>
      <li><a class="link" href="">個人情報保護方針</a></li>
      <li><a class="link" href="">お問い合わせ</a></li>
      </ul>
    </div>

    <div style="clear: both; overflow: hidden; padding-top: 1.6em;">
    <?php WPTM::render('template/partial/common/share/bootstrap_footer'); ?>
    </div>

    <div style="text-align: right;">
      <div>
        <img src="<?php echo WPTM::option('logo_footer'); ?>" style="width: 180px;"/>
      </div>
      <div class="">
        &copy; 2020 YOURCOOLCOMPANY All rights reserved.
      </div>
    </div>

  </div>

</div>


