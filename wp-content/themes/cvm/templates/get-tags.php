<?php if(has_tag()) : ?>
<div class="row">
<div class="col-xs-12">
  <div class="tags-container">
    <?php the_tags('Tags: ', '' ); ?>
  </div>
</div>
</div>
<?php endif; ?>