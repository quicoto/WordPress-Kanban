<?php

function get_all_items( $data ) {
  $args = array(
    'numberposts' => -1,
    'post_type'   => 'item',
    'tax_query' => array(
      array(
          'taxonomy' => 'board',
          'field'    => 'id',
          'terms'    => $data['id']
      )
    )
  );

  $posts = get_posts($args);
  if ( empty( $posts ) ) {

    return null;
  }

  return $posts;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'kanban/v1', '/items/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_items',
  ) );
} );