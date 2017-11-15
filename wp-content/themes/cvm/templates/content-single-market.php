<?php while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?>>

  	<div class="entry-content">

	  	<div class="page-header">
	    	<h3><?php the_title(); ?></h3>
	  	</div>

	  	<?php the_content(); ?>

  	</div>

	</article>

<?php endwhile; ?>
