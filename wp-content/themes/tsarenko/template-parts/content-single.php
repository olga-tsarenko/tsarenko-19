<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tsarenko
 */

?>

<div>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php
            echo get_the_post_thumbnail(null);
            ?>
            <?php the_title('<h1 class="entry-title">', '</h1>');
            if ('post' === get_post_type()) : ?>
                <div class="entry-meta">
                    <?php
                    $author = get_the_author();
                    echo 'by '. $author;

                    echo ' <span class="comm"> ' . get_comments_number() . '</span><span class="label-num-comments">comments</span>';
                    the_time('M. j, Y');
                    ?>

                </div><!-- .entry-meta -->
                <?php
            endif;
            ?>

        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
            the_content();

            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'tsarenko'),
                'after' => '</div>',
            ));
            ?>
        </div><!-- .entry-content -->

        <?php if (get_edit_post_link()) : ?>

            <footer class="entry-footer">
                <?php
                edit_post_link(
                    sprintf(
                    /* translators: %s: Name of current post */
                        esc_html__('Edit %s', 'tsarenko'),
                        the_title('<span class="screen-reader-text">"', '"</span>', false)
                    ),
                    '<span class="edit-link">',
                    '</span>'
                );
                ?>
            </footer><!-- .entry-footer -->
        <?php endif; ?>
    </article><!-- #post-## -->
    <div class="similar_records">
        <h3>Related posts</h3>
        <?php $tags = wp_get_post_tags($post->ID);

        if ($tags) {

            $tag_ids = array();

            foreach ($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

            $args = array(

                'tag__in' => $tag_ids, // Сортировка производится по тегам

                'post__not_in' => array($post->ID),

                'showposts' => 3// Цифра означает количество выводимых записей

            );

            $my_query = new wp_query($args);

            if ($my_query->have_posts()) {
                echo '<ul>';
                while ($my_query->have_posts()) {
                    $my_query->the_post();
                    ?>
                    <li>
                        <div class="cell"><a class="href-img" onclick="return !window.open(this.href)"
                                             href="<?php the_permalink() ?>">
                                <?php the_post_thumbnail('related-thumb'); ?></a><br>
                            <a class="title-related" onclick="return !window.open(this.href)"
                               href="<?php the_permalink() ?>" rel="bookmark"
                               title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
                    </li>

                    <?php
                }
                echo '</ul>';
            }
            wp_reset_query();
        } ?>
    </div>
</div>