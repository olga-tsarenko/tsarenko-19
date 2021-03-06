<?php
/**
 * Template part for displaying page content in home.php
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (!is_sticky()) { ?>
        <header class="entry-header">
<!--            --><?php
//            echo get_the_post_thumbnail();
//            ?>

            <?php
            if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'homepage-thumb' );
            } ?>


            <?php
            if (is_single()) :
                the_title('<h1 class="entry-title">', '</h1>');
            else :
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                the_excerpt();
            endif;
            if ('post' === get_post_type()) :
                if (!is_sticky()) { ?>
                    <div class="entry-meta">
                        <?php
                        $author = get_the_author();
                        echo 'by '. $author;
                        echo ' <span class="comm"> ' . get_comments_number() . '</span><span class="label-num-comments">comments</span>';
                        the_time('M. j, Y');
                        ?>

                    </div><!-- .entry-meta -->
                <?php }
            endif; ?>
            <?php ?>
        </header><!-- .entry-header -->
    <?php } ?>

    <?php if (is_sticky()) { ?>
        <div class="entry-content">
            <?php
            the_content(sprintf(
            /* translators: %s: Name of current post. */
                wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'tsarenko'), array('span' => array('class' => array()))),
                the_title('<span class="screen-reader-text">"', '"</span>', false)
            ));

            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'tsarenko'),
                'after' => '</div>',
            ));
            ?>

        </div><!-- .entry-content -->
    <?php } else {

    } ?>


    <footer class="entry-footer">
        <?php tsarenko_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article>


