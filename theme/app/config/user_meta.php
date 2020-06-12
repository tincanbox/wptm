<?php

return array(
  'admin' => array(
    'managenav-menuscolumnshidden' => array(),
    'metaboxhidden_post' => array(
      'slugdiv',
      #'authordiv',
      #'postcustom',
      #'trackbacksdiv',
    ),
    'meta-box-order_post' => array(
      'side'    => 'submitdiv,slugdiv,authordiv,postimagediv,categorydiv,tagsdiv-post_tag,formatdiv',
      'normal'  => 'postexcerpt,postcustom,commentstatusdiv,commentsdiv,trackbacksdiv',
    ),
    'metaboxhidden_page' => array(
      #'page_eyecatch',
      #'postcustom',
      #'commentstatusdiv',
      #'commentsdiv',
      #'slugdiv',
      #'authordiv',
    ),
    'meta-box-order_page' => array(
      'side'    => 'submitdiv,pageparentdiv,slugdiv,authordiv,page_eyecatch,postimagediv',
      'normal'  => 'commentstatusdiv,commentsdiv,postcustom',
    )
  )
);
