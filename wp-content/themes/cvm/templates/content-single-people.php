<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>

    <div class="page-header">
      <h3>People</h3>
    </div>

    <div class="entry-content person">

      <div class="row">

        <div class="col-sm-5 col-md-12 col-lg-5">
          <?php the_post_thumbnail('full', [
            'class' => 'img-responsive'
          ]); ?>
          <a href="<?php echo site_url('people'); ?>" class="btn btn-gray before">Back to People</a>
        </div>

        <div class="col-sm-7 col-md-12 col-lg-7">
          <div class="person-title"><?php the_title(); ?></div>
          <?php the_content(); ?>
        </div>
        
      </div>

      <?php get_template_part('templates/get-tags'); ?>

    </div>

  </article>
<?php endwhile; ?>
