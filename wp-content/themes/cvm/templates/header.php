<header class="banner">

  <div class="container">

    <div class="row">

      <div class="col-md-12">

        <a class="brand" href="<?= esc_url(home_url('/')); ?>">
          <img class="img-responsive" src="<?php echo get_template_directory_uri (); ?>/dist/images/logo.png">
        </a>

        <div class="nav-primary-container">

          <div class="visible-xs visible-sm pull-right">
          
            <a href="#nav-primary-mobile" class="navbar-toggle collapsed pull-left">
                <div class="pull-left">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </div>
                <div class="pull-left icon-bar-text hidden-xs">Menu</div>
            </a>

            <?php if (has_nav_menu('primary_navigation')) :
              wp_nav_menu([
                'container' => 'nav',
                'container_id' => 'nav-primary-mobile',
                'theme_location' => 'primary_navigation'
              ]);
            endif; ?>

          </div>

          <?php if (has_nav_menu('primary_navigation')) :
            wp_nav_menu([
              'container' => 'nav',
              'container_class' => 'nav-primary hidden-xs hidden-sm',
              'theme_location' => 'primary_navigation',
              'menu_class' => 'nav navbar-nav',
              'walker' => new wp_bootstrap_navwalker()
            ]);
          endif; ?>

          <div class="search-container pull-right">
            <a href="#" id="search-btn">
              <i class="fa fa-search"></i>
            </a>
            <?php get_search_form(); ?>
          </div>
          
        </div>

      </div>

    </div>

  </div>

</header>