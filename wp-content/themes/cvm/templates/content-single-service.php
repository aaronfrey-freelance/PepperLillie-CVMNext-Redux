<?php while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?>>

	  	<div class="entry-content">

	  		<?php if ('service' == get_post_type() && has_term('top-level', 'type')) : ?>

				<?php $post_object = get_field('featured_service_project');

				if ($post_object) : 
					$post = $post_object;
					setup_postdata($post);

					$thumb_id = get_post_thumbnail_id($post->ID);
      				$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
      				$thumb_url = $thumb_url_array[0];
				?>

				<a href="<?php echo $post->guid; ?>" class="service-project-box large" style="background-image: url(<?php echo $thumb_url; ?>);">
					<div class="project-title"><?php echo $post->post_title; ?></div>
				</a>

				<?php wp_reset_postdata(); ?>
				
				<?php endif; ?>

	  		<?php else: 
				$thumb_id = get_post_thumbnail_id();
  				$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
  				$thumb_url = $thumb_url_array[0];
	  		?>
	  			<div class="service-project-box large" style="background-image: url(<?php echo $thumb_url; ?>);"></div>
	  			
	  		<?php endif; ?>

	      	<div class="page-header">
	        	<h3><?php the_title(); ?></h3>
	      	</div>

	      	<?php the_content(); ?>

	  	</div>

	</article>

<?php endwhile; ?>
