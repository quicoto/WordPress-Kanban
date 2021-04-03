<?php

function get_all_boards() {

  $output = get_terms( 'board', array(
    'hide_empty' => false,
  ) );

  usort($output, function($a, $b) {return strcmp($a->name, $b->name);});

  foreach ($output as &$term) {
    $args = array(
      'numberposts' => -1,
      'post_type'   => 'item',
      'tax_query' => array(
        array(
            'taxonomy' => 'board',
            'field'    => 'id',
            'terms'    => $term->term_id
        )
      )
    );

    $posts = get_posts($args);

    // Can this be done in a more performant way?
    foreach ($posts as &$post) {
      $post->status = (int) get_post_meta( $post->ID, 'status', true );
    }

    $term->items = $posts;
  }

  return $output;
}

function create_item ($data) {
  $post = array(
    'post_title'    => wp_strip_all_tags( $data['post_title'] ),
    'post_content'  => $data['post_content'],
    'post_status'   => 'publish',
    'post_type' => 'item'
  );

  $post_id = wp_insert_post( $post );
  wp_set_object_terms(
    $post_id,
    array($data['board']),
    'board'
  );
  add_post_meta($post_id, 'status', $data['status'], true );
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'kanban/v1', '/all-boards', array(
    'methods' => 'GET',
    'callback' => 'get_all_boards',
  ) );

  register_rest_route( 'kanban/v1', '/create-item', array(
    'methods' => 'POST',
    'callback' => 'create_item',
  ) );
} );
