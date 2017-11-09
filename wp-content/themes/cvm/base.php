<?php
use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
?>

<!doctype html>
<html <?php language_attributes(); ?>>

  <?php get_template_part('templates/head'); ?>

  <body <?php body_class(); ?>>

    <?php
      do_action('get_header');
      get_template_part('templates/header');

      // Get the ghosted background image if there is one
      $ghost = get_field('ghosted_image', 'option');
    ?>

    <div class="ghost-image" style="background-image: url(<?php echo $ghost; ?>);">

      <div class="container main-container" role="document">

        <div class="row">

          <div class="col-md-12 main-column">

            <main class="main col-md-8 clearfix">
              <?php include Wrapper\template_path(); ?>
            </main><!-- /.main -->

            <?php if (Setup\display_sidebar()) : ?>
              <aside class="sidebar col-md-4 clearfix">
                <?php include Wrapper\sidebar_path(); ?>
              </aside><!-- /.sidebar -->
            <?php endif; ?>

          </div><!-- /.col -->

        </div><!-- /.row -->
        
      </div><!-- /.container -->

    </div>

    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  </body>
</html>
