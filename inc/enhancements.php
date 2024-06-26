<?php 

// show all types of post types @ wp-admin / at a glance
add_action('dashboard_glance_items', 'at_glance_content_table_end');
function at_glance_content_table_end()
{
  $args = array(
    'public' => true,
    '_builtin' => false
  );
  $output = 'object';
  $operator = 'and';

  $post_types = get_post_types($args, $output, $operator);
  foreach ($post_types as $post_type) {
    $num_posts = wp_count_posts($post_type->name);
    $num = number_format_i18n($num_posts->publish);
    $text = _n($post_type->labels->singular_name, $post_type->labels->name, intval($num_posts->publish));
    if (current_user_can('edit_posts')) {
      $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
      echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
    }
  }
}

// add custom login logo to wp-login.php
function custom_loginlogo() {
  // set width of logo
  // set background-color of button-primary
  echo 
  '<style type="text/css">
    body.login #login h1 a {background-image: url('.get_bloginfo('template_directory').'/media/login_logo.png) !important; width: 320px; background-size: contain; }
    body.login #backtoblog a,  body.login #nav a { color: #000; }
		body.login #backtoblog a:hover,  body.login #nav a:hover{ text-decoration: underline; }
		body.wp-core-ui .button-primary { border: none; background-color: #000; box-shadow: none; text-shadow: none; transition: .2s;}
		body.wp-core-ui .button-primary:hover{ background-color: #000; opacity: 0.8; }
  </style>';
}
add_action('login_head', 'custom_loginlogo');
