<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

/* Start Custom Functions */

// Add custom bootstrap walker for dropdown menus
require_once('wp_bootstrap_navwalker.php');

// Filter the ACF Post Type Query
function my_post_object_query($args, $field, $post_id) {
  if($field['name'] === 'featured_service_project') {
    // only show children of the current post being edited
    $args['post_parent'] = $post_id;
  }  
  return $args;  
}

// filter for every field
add_filter('acf/fields/post_object/query', 'my_post_object_query', 10, 3);

// Create the Service type
add_action('init', 'create_custom_post_types');

function create_custom_post_types() {

  register_post_type('people',
    array(
      'labels' => array(
        'name' => __('People'),
        'singular_name' => __('Person'),
        'add_new_item' => 'Add New Person',
        'edit_item' => 'Edit Person',
        'featured_image' => 'Portrait',
        'set_featured_image' => 'Set Portrait',
        'remove_featured_image' => 'Remove Portrait'
      ),
      'public' => true,
      'show_in_nav_menus' => true,
      'menu_icon' => 'dashicons-groups',
      'taxonomies' => array('post_tag'),
      'supports' => ['editor', 'title', 'thumbnail', 'page-attributes']
    )
  );

  register_taxonomy('position', 'people', array(
    'hierarchical' => true,
    'labels' => array(
      'name' => _x('Positions', 'taxonomy general name'),
      'singular_name' => _x('Position', 'taxonomy singular name'),
      'all_items' => __('All Positions'),
      'parent_item' => null,
      'parent_item_colon' => null,
      'edit_item' => __('Edit Position'), 
      'update_item' => __('Update Position'),
      'add_new_item' => __('Add New Position'),
      'new_item_name' => __('New Position Name'),
      'menu_name' => __('Positions'),
    ),
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array('slug' => 'position'),
  ));

  register_post_type('market',
    array(
      'labels' => array(
        'name' => __('Markets'),
        'singular_name' => __('Market'),
        'add_new_item' => 'Add New Market',
        'edit_item' => 'Edit Market',
        'featured_image' => 'Market Image',
        'set_featured_image' => 'Set Market Image',
        'remove_featured_image' => 'Remove Market Image'
      ),
      'public' => true,
      'show_in_nav_menus' => true,
      'menu_icon' => 'dashicons-building',
      'hierarchical' => true,
      'supports' => ['editor', 'title', 'thumbnail']
    )
  );

  register_post_type('project-type',
    array(
      'labels' => array(
        'name' => __('Projects'),
        'singular_name' => __('Project'),
        'add_new_item' => 'Add New Project',
        'edit_item' => 'Edit Project',
        'featured_image' => 'Project Image',
        'set_featured_image' => 'Set Project Image',
        'remove_featured_image' => 'Remove Project Image'
      ),
      'public' => true,
      'show_in_nav_menus' => true,
      'menu_icon' => 'dashicons-building',
      'hierarchical' => true,
      'supports' => ['editor', 'title', 'thumbnail', 'page-attributes']
    )
  );

  $labels = array(
    'name'                       => __( 'Project Types' ),
    'singular_name'              => __( 'Project Type' ),
    'search_items'               => __( 'Search Project Types' ),
    'popular_items'              => __( 'Popular Project Types' ),
    'all_items'                  => __( 'All Project Types' ),
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'edit_item'                  => __( 'Edit Project Type' ),
    'update_item'                => __( 'Update Project Type' ),
    'add_new_item'               => __( 'Add New Project Type' ),
    'new_item_name'              => __( 'New Project Type Name' ),
    'separate_items_with_commas' => __( 'Separate Project Types with commas' ),
    'add_or_remove_items'        => __( 'Add or remove Project Types' ),
    'choose_from_most_used'      => __( 'Choose from the most used Project Types' ),
    'not_found'                  => __( 'No Project Types found.' ),
    'menu_name'                  => __( 'Project Types' ),
  );

  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var'             => true
  );
  register_taxonomy("project-types", "project-type", $args);

  register_post_type('service',
    array(
      'labels' => array(
        'name' => __('Services'),
        'singular_name' => __('Service'),
        'add_new_item' => 'Add New Service',
        'edit_item' => 'Edit Service',
        'featured_image' => 'Service Image',
        'set_featured_image' => 'Set Service Image',
        'remove_featured_image' => 'Remove Service Image'
      ),
      'public' => true,
      'show_in_nav_menus' => true,
      'menu_icon' => 'dashicons-building',
      'hierarchical' => true,
      'taxonomies' => array('post_tag'),
      'supports' => ['editor', 'page-attributes', 'title', 'thumbnail']
    )
  );

  $labels = array(
    'name'                       => __( 'Service Types' ),
    'singular_name'              => __( 'Service Type' ),
    'search_items'               => __( 'Search Service Types' ),
    'popular_items'              => __( 'Popular Service Types' ),
    'all_items'                  => __( 'All Service Types' ),
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'edit_item'                  => __( 'Edit Service Type' ),
    'update_item'                => __( 'Update Service Type' ),
    'add_new_item'               => __( 'Add New Service Type' ),
    'new_item_name'              => __( 'New Service Type Name' ),
    'separate_items_with_commas' => __( 'Separate Service Types with commas' ),
    'add_or_remove_items'        => __( 'Add or remove Service Types' ),
    'choose_from_most_used'      => __( 'Choose from the most used Service Types' ),
    'not_found'                  => __( 'No Service Types found.' ),
    'menu_name'                  => __( 'Service Types' ),
  );

  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'writer' ),
  );
  register_taxonomy("type", "service", $args);

}

// Are we on a Service page?
function is_service_page() {
  global $post;
  if($post->post_type === 'service' && !is_tag() && !is_search()) {
    return get_depth($post->ID);
  }
  return false;
}

// Are we on a Market page?
function is_market_page() {
  global $post;
  return $post->post_type === 'market' && !is_tag() && !is_search();
}

// Are we on a Project Type page?
function is_project_type_page() {
  global $post;
  return $post->post_type === 'project-type' && !is_tag() && !is_search();
}

// Get the service page color
function get_service_color() {
  global $post;
  $service_color = null;
  if (is_service_page()) {
    $parent = array_reverse(get_post_ancestors($post->ID));
    $first_parent = get_page($parent[0]);
    $service_color = get_field('service_color', $first_parent->ID);
  }
  return $service_color;
}

add_filter('get_the_archive_title', function ($title) {
  if(is_tag()) {
    $title = single_cat_title( '', false );
  } else if(is_archive()) {
    $title = post_type_archive_title('', true);
  }
  return $title;
});

function post_type_tags($post_type = '') {
  global $wpdb;

  if (empty($post_type)) {
    $post_type = get_post_type();
  }

  return $wpdb->get_results( $wpdb->prepare("
    SELECT COUNT(DISTINCT tr.object_id)
      AS count, tt.taxonomy, tt.description, tt.term_taxonomy_id, t.name, t.slug, t.term_id 
    FROM {$wpdb->posts} p 
    INNER JOIN {$wpdb->term_relationships} tr ON p.ID=tr.object_id 
    INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id 
    INNER JOIN {$wpdb->terms} t ON t.term_id=tt.term_taxonomy_id 
    WHERE p.post_type=%s AND tt.taxonomy='post_tag' 
    GROUP BY tt.term_taxonomy_id 
    ORDER BY count DESC
    ", $post_type));
}

function get_depth($postid) {
  $depth = ($postid == get_option('page_on_front')) ? -1 : 0;
  while ($postid > 0) {
    $postid = get_post_ancestors($postid);
    $postid = $postid[0];
    $depth++;
  }
  return $depth;
}

if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page(array(
    'page_title'  => 'Home Page Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));
  
  acf_add_options_sub_page(array(
    'page_title'  => 'Featured Post Types',
    'menu_title'  => 'Featured Post Types',
    'parent_slug' => 'theme-general-settings',
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Social Links',
    'menu_title'  => 'Social Links',
    'parent_slug' => 'theme-general-settings',
  ));
  
}

function get_posts_children($parent_id, $post_type = "service") {
  $children = array();
  // grab the posts children
  $posts = get_posts(array(
    'numberposts' => -1,
    'post_status' => 'publish',
    'post_type' => $post_type,
    'post_parent' => $parent_id,
    'suppress_filters' => false));

  // now grab the grand children
  foreach($posts as $child) {
      // recursion!! hurrah
      $gchildren = get_posts_children($child->ID);
      // merge the grand children into the children array
      if (!empty($gchildren)) {
        $children = array_merge($children, $gchildren);
      }
  }
  // merge in the direct descendants we found earlier
  $children = array_merge($children,$posts);
  return $children;
}

/**
* Dynamically add a sub-menu item to an existing menu item in wp_nav_menu
* only if a user is logged in.
*/
 function isa_dynamic_submenu_logout_link( $items, $args ) {
  foreach ($items as $item) {
    if ($item->post_name === 'featured-projects') {
      $item->classes[] = 'menu-item-has-children';
      $menu_id = $item->ID;
      // get all of the featured projects
      $projects = get_field('featured_projects', 'option');
      foreach ($projects as $idx => $project) {
        $item = array(
          'title'            => $project->post_title,
          'menu_item_parent' => $menu_id,
          'url'              => $project->guid
        );
        $items[] = (object) $item;
      }
    }
  }
  return $items;
}
add_filter( 'wp_nav_menu_objects', 'isa_dynamic_submenu_logout_link', 10, 2 );
