<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tsarenko
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="main-footer">
        <div class="container">
            <div class="widgets-inner">
                <?php if (is_active_sidebar('footer1')) :
                    dynamic_sidebar('footer1');
                endif; ?>
            </div>
            <div class="widgets-inner">
                <?php if (is_active_sidebar('footer2')) :
                    dynamic_sidebar('footer2');
                endif; ?>
            </div>
            <div class="widgets-inner">
                <?php if (is_active_sidebar('footer3')) :
                    dynamic_sidebar('footer3');
                endif; ?>
            </div>
        </div>
    </div>
    <div class="low-footer">
        <div class="container">
            <div class="site-info">
                <div>Copyright <?php echo date('Y'); ?> - <a href="#">FreeForWebDesign.com</a> - All Rights Reserved
                </div>
            </div><!-- .site-info -->
            <nav id="second-navigation" class="footer-navigation" role="navigation">
                <?php wp_nav_menu(array('theme_location' => 'menu-1', 'menu_id' => 'primary-menu')); ?>
            </nav><!-- #site-navigation -->
        </div><!--container closed-->
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
