<?php 

/**
 * Add options page
 */
add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init()
{
  // Check function exists.
  if (function_exists('acf_add_options_page')) {
    // Register options page.
    $option_page = acf_add_options_page(array(
      'page_title'    => 'הגדרות תבנית',
      'menu_title'    => 'הגדרות תבנית',
      'menu_slug'     => 'acf-theme-settings',
      'capability'    => 'edit_posts',
      'redirect'      => false
    ));
  }
}

/** 
 * Links
 */

// Print ACF Links (escaped for safe output)
function printLink($link, $class = '')
{
  if (empty($link['url'])) {
    return '';
  }
  $link_target = !empty($link['target']) ? $link['target'] : '_self';
  $attr_class  = ($class !== '') ? ' class="' . esc_attr($class) . '"' : '';
  return '<a href="' . esc_url($link['url']) . '"' . $attr_class . ' target="' . esc_attr($link_target) . '">' . esc_html($link['title']) . '</a>';
}

// Print Social Links (escaped for safe output)
function printSocialLink($link_url, $icon_class, $link_name)
{
  if ($link_url && $icon_class && $link_name) {
    return '<li><a rel="noopener noreferrer" href="' . esc_url($link_url) . '"><i aria-hidden="true" class="' . esc_attr($icon_class) . '"></i> <span>' . esc_html($link_name) . '</span></a></li>';
  }
  return '';
}

/**
 * _s Customize ACF oEmbed
 */
function _s_custom_oembed($iframe)
{
	preg_match('/src="(.+?)"/', $iframe, $matches);
	$src = $matches[1];

	$params = array(
		'hd'   => 1,
		'rel'  => 0
	);
	$new_src = add_query_arg($params, $src);
	$iframe = str_replace($src, $new_src, $iframe);

	// Add extra attributes to iframe HTML.
	$attributes = 'frameborder="0"';
	$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

	// Display customized HTML.
	return $iframe;
}