<?php

function get_board($data) {
  return get_all_boards((int) $data['id']);
}

function get_all_boards($term_id) {
  if (is_numeric($term_id)) {
    $output = array(get_term( $term_id, 'board' ));
  } else {
    $output = get_terms( 'board', array(
      'hide_empty' => false,
    ) );
  }

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
      ),
      'meta_query' => array(
        array(
            'key' => 'status',
            'value' => array(1, 2, 3),
            'compare' => 'IN'
        )
      )
    );

    $posts = get_posts($args);

    // Can this be done in a more performant way?
    foreach ($posts as &$post) {
      $post->post_content = make_clickable($post->post_content);
      $post->status = (int) get_post_meta( $post->ID, 'status', true );
      $post->date = date_i18n( get_option( 'date_format' ), strtotime( $post->post_modified ) );
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

function update_item_status ($data) {
  // Force the post_modified to be updated
  wp_update_post( array( 'ID' => $data['itemId'] ) );

  return update_post_meta($data['itemId'], 'status', $data['status'] );
}

function update_item ($data) {
  $my_post = array(
    'ID'           => $data['ID'],
    'post_title'   => $data['post_title'],
    'post_content' => $data['post_content']
  );

  wp_update_post( $my_post );
}

function get_user_logged_in() {
  return is_user_logged_in() ? 'yes' : 'no';
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'kanban/v1', '/is-user-logged-in', array(
    'methods' => 'POST',
    'callback' => 'get_user_logged_in',
  ) );

  register_rest_route( 'kanban/v1', '/all-boards', array(
    'methods' => 'GET',
    'callback' => 'get_all_boards',
  ) );

  register_rest_route( 'kanban/v1', '/board/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_board'
  ) );

  register_rest_route( 'kanban/v1', '/create-item', array(
    'methods' => 'POST',
    'callback' => 'create_item',
  ) );

  register_rest_route( 'kanban/v1', '/update-item-status', array(
    'methods' => 'POST',
    'callback' => 'update_item_status',
  ) );

  register_rest_route( 'kanban/v1', '/update-item', array(
    'methods' => 'POST',
    'callback' => 'update_item',
  ) );
} );
