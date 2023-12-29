<?php get_header(); ?>

<div class="page-wrapper">

    <?php 
        if ( have_posts() ) {
		    while ( have_posts() ) {
			    the_post();
                $post_format = get_post_format();
                if ( $post_format ) {
                    get_template_part( 'template-parts/content', $post_format );
                } else {
                    if ( is_search() || is_archive() || is_home() ) {
                        get_template_part( 'template-parts/archive', $post_format );
                    } else {
                        get_template_part( 'template-parts/content', get_post_type() );
                    }
                }
            }

            mv_2024_the_posts_navigation();
        }
    ?>
</div>

<?php
get_footer();
