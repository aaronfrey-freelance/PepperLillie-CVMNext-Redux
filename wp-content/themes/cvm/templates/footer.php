<footer class="content-info">

  	<div class="container">

	  	<div class="row">

			<div class="col-md-12 news-ticker">

			<?php

				$post_objects = get_field('featured_news_story', 'option');

				usort($post_objects, function($a, $b) {
					return strtotime($b->post_date) - strtotime($a->post_date);
				});

				if ($post_objects) : ?>

					<div id="marquee">
		   				<a href="<?php echo site_url('news'); ?>">News :</a>
						<?php foreach ($post_objects as $post) : setup_postdata($post); ?>
							<a class="marquee-item" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<?php endforeach;
						wp_reset_postdata(); ?>
					</div>
				<?php endif; ?> 

			</div>

		  	<div class="footer-nav col-sm-5">
				<?php dynamic_sidebar('sidebar-footer-left'); ?>
		  	</div>

	  		<div class="footer-nav footer-contact col-sm-offset-3 col-sm-4">

			    <div class="social-links">
					<?php if(get_field('linkedin_url', 'option')) : ?>
						<a href="<?php the_field('linkedin_url', 'option'); ?>" target="_blank"  title="Linkedin Link">
							<i class="fa fa-linkedin"></i>
						</a>
					<?php endif; ?>
					<?php if(get_field('facebook_url', 'option')) : ?>
						<a href="<?php the_field('facebook_url', 'option'); ?>" target="_blank" title="Facebook Link">
							<i class="fa fa-facebook"></i>
						</a>
					<?php endif; ?>
					<?php if(get_field('twitter_url', 'option')) : ?>
						<a href="<?php the_field('twitter_url', 'option'); ?>" target="_blank" title="Twitter Link">
							<i class="fa fa-twitter"></i>
						</a>
					<?php endif; ?>
			    </div>

	  			<?php dynamic_sidebar('sidebar-footer'); ?>
	  		</div>

	  	</div>

  	</div>

</footer>