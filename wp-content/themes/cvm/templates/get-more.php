<div class="get-more">

	<div class="row">
		<div class="col-sm-6">
	  	<div class="social-share clearfix">
	  		<div class="post-date">
	  			Posted on <?php the_time(get_option('date_format')); ?>
	  		</div>
	  		<span class='st_twitter' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
				<span class='st_facebook' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
				<span class='st_linkedin' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
				<span class='st_tumblr' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
				<span class='st_email' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
	  	</div>			
		</div>
		<?php if(!is_single()) : ?>
		<div class="col-sm-6">
			<a href="<?php the_permalink(); ?>" class="btn btn-gray after pull-right">Read More</a>
		</div>
		<?php endif; ?>
	</div>

</div>