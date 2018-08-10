<?php if (is_front_page()) : ?>

  <?php $the_query = new WP_Query([
    'post_type' => 'market',
    'post_status' => 'publish',
    'post_parent' => 0
  ]);

  if ($the_query->have_posts()) : ?>

    <div class="services-header">Markets</div>

    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

      <a href="<?php the_permalink(); ?>" class="service-container">

        <?php if (has_post_thumbnail()) : ?>
          <?php the_post_thumbnail('thumbnail', ['class' => 'pull-left service-image']); ?>
        <?php else : ?>
          <img class="pull-left service-image" src="http://placehold.it/91x91">
        <?php endif; ?>

        <div class="pull-left service-info">
          <div class="service-title"><?php the_title(); ?></div>
          <div class="service-description"><?php the_field('market_description'); ?></div>
        </div>
        <i class="pull-right fa fa-chevron-right"></i>

      </a>

    <?php endwhile; ?>

  <?php endif; wp_reset_postdata(); ?>

<?php elseif (is_market_page()) :

  $images = get_field('market_images');

  if ($images) : ?>

    <div style="margin-top: 49px;">

    <?php foreach ($images as $image) : ?>

      <div
        class="service-project-box"
        style="background-image: url(<?php echo $image['sizes']['large']; ?>);">
        <div class="project-title"><?php echo $image['alt']; ?></div>
      </div>

    <?php endforeach; ?>

    </div>

  <?php endif; ?>

<?php elseif (is_project_type_page()) : ?>
  
  <?php if (have_rows('featured_projects')) : ?>

    <div class="row">

      <?php while (have_rows('featured_projects')) : the_row();

        if (get_sub_field('is_internal_project')) : ?>

          <?php

          $post_object = get_sub_field('project_post');

          if ($post_object) :

            // override $post
            $post = $post_object;
            setup_postdata($post);

            $thumb_id = get_post_thumbnail_id($post->ID);
            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
            $thumb_url = $thumb_url_array[0]; ?>

            <a href="<?php echo get_permalink(); ?>"
              class="service-project-box"
              style="background-image: url(<?php echo $thumb_url; ?>);">
              <div class="project-title"><?php echo $post->post_title; ?></div>
            </a>

            <?php wp_reset_postdata(); ?>
          
          <?php endif; ?>

        <?php else : ?>

          <?php $image = get_sub_field('project_image'); ?>

          <div
            class="service-project-box"
            style="background-image: url(<?php echo $image['url']; ?>);">
            <div class="project-title">
              <?php the_sub_field('project_title'); ?>
            </div>
          </div>

        <?php endif; ?>

      <?php endwhile; ?>

    </div><!-- .row -->

  <?php elseif(have_rows('project_images')) : ?>

    <div class="row parent-container">

      <?php while (have_rows('project_images')) : the_row();

        $image = get_sub_field('project_image'); ?>
        
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

elseif (is_page('profile')) :

  $menu_items = wp_get_nav_menu_items('Header Navigation');
  $services_id = 0;
  $services_sub = [];

  foreach ($menu_items as $menu_item) {
    if($menu_item->title === 'Services') {
      $services_id = $menu_item->ID;
      break;
    }
  }

  if ($services_id) {
    foreach($menu_items as $menu_item) {
      if($menu_item->menu_item_parent == $services_id) {
        $services_sub[$menu_item->object_id] = null; 
      }
    }
  } ?>

  <div class="sidebar-profile">

  <?php 

  // Get all of the top level services
  $args = array(
    'posts_per_page' => -1,
    'post_type' => 'service'
  );

  $top_level_services = get_posts($args);

  foreach ($top_level_services as $post) :
    setup_postdata($post);
    $featured_project = get_field('featured_service_project', $post->ID);
    if ($featured_project && array_key_exists($post->ID, $services_sub)) {
      $services_sub[$post->ID] =
        ['project' => $featured_project, 'service_name' => $post->post_title];
    }
  endforeach;
  wp_reset_postdata();

  foreach ($services_sub as $featured_project) :

    if ($featured_project) :

      $thumb_id = get_post_thumbnail_id($featured_project['project']->ID);
      $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
      $thumb_url = $thumb_url_array[0]; ?>

      <a href="<?php echo get_permalink($featured_project['project']->post_parent); ?>"
        class="service-project-box"
        style="background-image: url(<?php echo $thumb_url; ?>);">
        <div class="project-title"><?php echo $featured_project['service_name']; ?></div>
      </a>

    <?php endif; ?>

  <?php endforeach; ?>

  </div>

<?php else :

  $is_service_project = has_term('service-projects', 'type');

  if (!$is_service_project) : ?>

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
  <?php if ($is_service_project && have_rows('project_images')) : ?>

    <div class="row parent-container">

      <?php while (have_rows('project_images')) : the_row();

        $image = get_sub_field('project_image'); ?>
        
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