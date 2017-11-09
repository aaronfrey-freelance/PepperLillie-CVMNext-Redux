<?php while (have_posts()) : the_post(); ?>

  <?php get_template_part('templates/page', 'header'); ?>
  <?php the_content(); ?>

  <?php 
  	$position_terms = get_terms('position', [
  		'orderby' => 'slug',
  		'order' => 'desc'
  	]);
	?>

	<?php foreach ($position_terms as $position_term) : ?>

	  <?php $member_group_query = new WP_Query(array(
	    'post_type' => 'people',
	    'tax_query' => array(
	      array(
			    'taxonomy' => 'position',
			    'field' => 'slug',
			    'terms' => array($position_term->slug),
			    'operator' => 'IN'
	      )
	    )
	  )); ?>

	  <?php if($member_group_query->have_posts()) : ?>
		<table class="people-table">
			<tr class="people-position">
				<th><?php echo $position_term->name; ?></th>
			</tr>
			<?php while($member_group_query->have_posts()) : $member_group_query->the_post(); ?>
	      <tr>
	      	<td>
	      		<a href="<?php the_permalink(); ?>">
	      			<?php the_title(); ?>
	      		</a>
	      	</td>
	      </tr>
	    <?php endwhile; ?>
		</table>
	  <?php endif; wp_reset_postdata(); ?>

	<?php endforeach; ?>

<?php endwhile; ?>