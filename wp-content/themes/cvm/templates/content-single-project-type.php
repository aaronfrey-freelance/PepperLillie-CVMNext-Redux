<?php while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?>>

	  <div class="entry-content">

	  	<?php
				
			$thumb_id = get_post_thumbnail_id();
  		$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
  		$thumb_url = $thumb_url_array[0];
	  	
	  	?>
	  		
	  	<div
	  		class="service-project-box large"
	  		style="background-image: url(<?php echo $thumb_url; ?>);"></div>

	    <div class="page-header">
	      <h3><?php the_title(); ?></h3>
	    </div>

	    <?php the_content(); ?>

	  </div>

	</article>

<?php endwhile; ?>
