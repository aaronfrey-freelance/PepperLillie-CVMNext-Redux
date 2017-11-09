<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'search'); ?>
<?php endwhile; ?>

<?php the_posts_pagination( array(
    'mid_size' => 2,
    'prev_text' => __('<i class="fa fa-chevron-left"></i>'),
    'next_text' => __('<i class="fa fa-chevron-right"></i>'),
)); ?>
