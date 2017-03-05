<?php
/**
 * Template Name: MyLayout
 */

get_header(); ?>

<div id="primary" class="content-area">
    <div class="blog-wrapper">
        <main id="main" class="site-main" role="main">

            <?php
            while (have_posts()) : the_post();


                get_template_part('template-parts/content','blog' );

                // If comments are open or we have at least one comment, load up the comment template.




            endwhile; // End of the loop.
            ?>


        </main><!-- #main -->

        <?php the_posts_pagination( array(
            'mid_size' => 2,
            'end_size' =>2
        ) );
        ; ?>
    </div>
</div><!-- #primary -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>


