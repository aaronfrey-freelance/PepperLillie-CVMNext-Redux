<div class="loading text-center">
    <img src="<?php echo get_template_directory_uri (); ?>/dist/images/ajax-loader.gif">
    <span class="sr-only">Loading...</span>
</div>

<div class="bxsliderWrapper" style="position:relative; visibility:hidden;">

    <ul class="latest-news">

    <?php $post_objects = get_field('home_page_slide', 'option');

        if ($post_objects) :

            foreach ($post_objects as $idx => $post) : setup_postdata($post);

                if (has_post_thumbnail()) : ?>

                <li
                    class="news-item"
                    data-slide-count="<?php echo $idx; ?>"
                    data-title="<?php the_title(); ?>"
                    data-location="<?php the_field('project_location', get_the_ID()); ?>"
                    data-link="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('slider'); ?>
                </li>

                <?php endif;

            endforeach; wp_reset_postdata();

        endif; ?>

    </ul>

    <div class="latest-news-info">
        <div class="clearfix">
            <div class="latest-news-nav pull-left">
                <div class="news-next"></div>
                <div id="news-pager"></div>
                <div class="news-prev"></div>
            </div>
        </div>
        <div id="news-title" class="latest-news-title"></div>
        <div id="news-location" class="latest-news-location"></div>
    </div>

</div>

<?php the_content(); ?>