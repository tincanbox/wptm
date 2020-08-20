<?php

global $wp_rewrite;
global $wp_query;
global $paged;


if ( null === $wp_query ) {
  global $wp_query;
}

$add_args = [];

//add query (GET) parameters to generated page URLs
/*if (isset($_GET[ 'sort' ])) {
  $add_args[ 'sort' ] = (string)$_GET[ 'sort' ];
}*/

$pages = paginate_links( array_merge( [
      'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
      'format'       => '?paged=%#%',
      'current'      => max( 1, get_query_var( 'paged' ) ),
      'total'        => $wp_query->max_num_pages,
      'type'         => 'array',
      'show_all'     => false,
      'end_size'     => 3,
      'mid_size'     => 1,
      'prev_next'    => true,
      'prev_text'    => __( '« Prev' ),
      'next_text'    => __( 'Next »' ),
      'add_args'     => $add_args,
      'add_fragment' => ''
  ], array() )
);

if ( is_array( $pages ) ) {
  //$current_page = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
  $pagination = '<div class="pagination"><ul class="pagination" style="margin:auto;">';

  foreach ( $pages as $page ) {
      $pagination .= '<li class="page-item' .
        (strpos($page, 'current') !== false ? ' active' : '')
        . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
  }

  $pagination .= '</ul></div>';

  echo $pagination;
}