<?php


/*
  ----------------------------------------------------
  Clean up wp_head
  ----------------------------------------------------
*/
remove_action('wp_head', 'rsd_link' );
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_print_styles', 'print_emoji_styles' );


/*
  ----------------------------------------------------
  Admin Display Configuration
  ----------------------------------------------------
*/

function hide_admin_bar_from_front_end(){
  if (is_blog_admin()) {
    return true;
  }
  return false;
}
add_filter( 'show_admin_bar', 'hide_admin_bar_from_front_end' );

// Remove Menu Items
function reo_remove_menu_pages ()
{
  remove_menu_page('index.php'); 
  remove_menu_page('edit.php');
  //remove_menu_page('edit.php?post_type=page');
  remove_menu_page('edit-comments.php');
  remove_menu_page('tools.php');
}
add_action('admin_menu', 'reo_remove_menu_pages');

// Options Pages
if( function_exists('acf_add_options_page') ) {

  acf_add_options_page(
    array(
      'page_title' => 'Homepage',
      'menu_title' => 'Homepage',
      'menu_slug' => 'homepage',
      'capability' => 'edit_posts',
      'redirect' => false,
      'position' => 2
    )
    
  );
  
  acf_add_options_page(
    array(
      'page_title' => 'Footer',
      'menu_title' => 'Footer',
      'menu_slug' => 'footer',
      'capability' => 'edit_posts',
      'redirect' => false,
      'position' => 3
    )
  );
}


// Custom Menu Order
function custom_menu_order($menu_order) 
{
    if ( ! $menu_order ) return true;
    return array(
        'upload.php', 
        'themes.php',
        'plugins.php',
        'users.php',
        'options-general.php',
        'edit.php?post_type=page',
        'edit.php?post_type=project'
    );
}
add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');


/*
  ----------------------------------------------------
  Post Types
  ----------------------------------------------------
*/

// Projects
function create_project_post_type () 
{
  register_post_type( 'project',
    array(
      'labels' => array(
        'name' => __( 'Projects' ),
        'singular_name' => __( 'Project' ),
        'add_new_item' => 'Add New Project'
      ),
    'public' => true,
    'rewrite' => array('slug' => 'projects'),
    'has_archive' => true,
    'menu_position' => 1
    )
  );
  flush_rewrite_rules(false); 
}
add_action('init', 'create_project_post_type');

/*
  ----------------------------------------------------
  Image Groups
  ----------------------------------------------------
*/
function add_image_crops() 
{
  
  // Image Grid
  add_image_size( 'hero-image', 1440, 810, true);
  
  // Featured Thumb
  add_image_size( 'featured-work', 420, 420, true);
  
  // Headshot
  add_image_size( 'headshot', 452, 225, true);
  
  // Award
  add_image_size( 'award', 196, 196, true);
  
  // Text and Media
  add_image_size( 'text-media', 620, 350, true);
  
  // Image Grid
  add_image_size( 'image-grid', 408, 250, true);
  
  // Cluster Images
  add_image_size( 'cluster-col-1-large', 514);
  add_image_size( 'cluster-col-2-large', 726);
  add_image_size( 'cluster-col-2-small', 340);

}
add_action('after_setup_theme', 'add_image_crops');

/*
  ----------------------------------------------------
  Utility
  ----------------------------------------------------
*/
function isMobile($user_agent=NULL) {
    if(!isset($user_agent)) {
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }
    return (strpos($user_agent, 'iPhone') !== FALSE ||
            strpos($user_agent, 'iPad') !== FALSE);
}

function inline_svg($file) {
  $svg = file_get_contents($file);
  echo preg_replace('!^[^>]+>(\r\n|\n)!', '', $svg);
}

function sanitize_output($buffer) {

    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(.|\s)*?-->/' // strip comments
    );

    $replace = array(
        '>',
        '<',
        '\\1'
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}
// ob_start("sanitize_output");


add_filter( 'acf/settings/load_json', function ( $paths ) {
	unset( $paths[0] );

	$paths[] = get_stylesheet_directory() . '/acf-json';

	return $paths;
} );
