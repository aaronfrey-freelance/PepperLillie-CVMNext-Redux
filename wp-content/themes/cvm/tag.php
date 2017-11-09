<?php get_template_part('templates/page', 'header'); ?>

<?php
  $results = false;
  $custom_types = array('service', 'people', 'news');
?>

<?php foreach ($custom_types as $custom_type) : ?>

  <?php $member_group_query = new WP_Query(array(
    'post_type' => $custom_type,
    'tag' => single_tag_title('', false),
    'orderby' => 'date',
    'order' => 'asc'
  )); ?>

  <?php if($member_group_query->have_posts()) : $results = true; $post_type_obj = get_post_type_object($custom_type); ?>
	<table class="people-table">
		<tr class="people-position">
			<th><?php echo $post_type_obj->labels->name; ?></th>
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

<?php if (!$results) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>