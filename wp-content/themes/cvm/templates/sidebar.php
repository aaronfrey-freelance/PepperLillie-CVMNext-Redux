<?php if (is_news_page()) :

  if (get_field('display_featured_news', 'options')) :

    $post_objects = get_field('featured_news_story', 'option');

    usort($post_objects, function($a, $b) {
      return strtotime($b->post_date) - strtotime($a->post_date);
    });

    if ($post_objects) : ?>

      <div class="col-sm-12">
        <h4 class="featured-news-header">Featured</h4>
      </div>

      <?php foreach ($post_objects as $post): setup_postdata($post); ?>
        <?php if (has_post_thumbnail()) : ?>
          <a class="col-sm-12 featured-news" href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('large', ['class' => 'img-responsive']); ?>
            <?php the_title(); ?>
          </a>
        <?php endif; ?>
      <?php endforeach; wp_reset_postdata();

    endif;

  endif; ?>

<?php elseif (is_page('profile')) :

$menu_items = wp_get_nav_menu_items('Header Navigation');
$services_id = 0;
$services_sub = [];

foreach($menu_items as $menu_item) {
  if($menu_item->title === 'Services') {
    $services_id = $menu_item->ID;
  }
}

if($services_id) {
  foreach($menu_items as $menu_item) {
    if($menu_item->menu_item_parent == $services_id) {
      $services_sub[$menu_item->object_id] = null; 
    }
  }
}

?>

  <div class="sidebar-profile">

  <?php 

  // Get all of the top level services
  $args = array(
    'posts_per_page' => -1,
    'post_type'   => 'service'
  );
  $top_level_services = get_posts($args);

  foreach ($top_level_services as $post) :
    setup_postdata($post);
    $featured_project = get_field('featured_service_project', $post->ID);
    if ($featured_project && array_key_exists($post->ID, $services_sub)) {
      $services_sub[$post->ID] = $featured_project;
    }
  endforeach;
  wp_reset_postdata();

  foreach ($services_sub as $featured_project) :

    if ($featured_project) :

      $thumb_id = get_post_thumbnail_id($featured_project->ID);
      $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
      $thumb_url = $thumb_url_array[0]; ?>

      <a href="<?php echo get_permalink($featured_project->post_parent); ?>" class="service-project-box" style="background-image: url(<?php echo $thumb_url; ?>);">
        <div class="project-title"><?php echo $featured_project->post_title; ?></div>
      </a>

    <?php endif; ?>

  <?php endforeach; ?>

  </div>

<?php else :

  $is_project = has_term('service-projects', 'type');
  
  if (!$is_project) : ?>

  <div class="row">

    <?php 

    // Get all of the service's child projects
    $projects = get_posts_children(get_the_ID());

    foreach ($projects as $project) :
      // Get the project's thumbnail url
      $thumb_id = get_post_thumbnail_id($project->ID);
      $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
      $thumb_url = $thumb_url_array[0];

      // Get the service's featured project
      $featured_service_project = get_field('featured_service_project');
    ?>
    
    <?php
      // Only show a child project if it is not the featured project
      if ($project->ID != $featured_service_project->ID) : ?>
      <div class="col-md-12 col-sm-4">
        <a
          href="<?php echo $project->guid; ?>"
          class="service-project-box"
          style="background-image: url(<?php echo $thumb_url; ?>);">
          <div class="project-title"><?php echo $project->post_title; ?></div>
        </a>
      </div>
    <?php endif; ?>

    <?php endforeach; ?>

  </div>

  <?php endif; ?>

  <!-- Show the project images -->
  <?php if ($is_project && have_rows('project_images')) : ?>

    <div class="row parent-container">

      <?php while (have_rows('project_images')) : the_row(); $image = get_sub_field('project_image'); ?>
        
        <div class="col-md-12 col-sm-4">
          <a
            href="<?php echo $image['url']; ?>"
            class="service-project-box"
            style="background-image: url(<?php echo $image['sizes']['large']; ?>);">
          </a>
        </div>
        
      <?php endwhile; ?>

    </div>

  <?php endif;

endif; ?>