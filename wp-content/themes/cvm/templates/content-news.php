<article <?php post_class(); ?>>

  <header>
    <h2 class="entry-title">
    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
  </header>

  <?php the_post_thumbnail('full', ['class' => 'img-responsive news-image']); ?>

  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>

  <?php get_template_part('templates/get-more'); ?>

</article>
