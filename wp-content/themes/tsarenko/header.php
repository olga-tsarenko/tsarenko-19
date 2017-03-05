<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tsarenko
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class('body-wrapper'); ?>>
<div id="page" class="site wrapper">
    <header id="masthead" class="site-header" role="banner">
        <div class="logo-nav">
            <div class="site-branding logo">
                <a href="/"><img src="<?php bloginfo('template_url'); ?>../images/logo.png" alt="logo"></a>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation" role="navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <?php esc_html_e('Primary Menu', 'tsarenko'); ?></button>
                <?php wp_nav_menu(array('theme_location' => 'menu-1', 'menu_id' => 'primary-menu')); ?>
            </nav><!-- #site-navigation -->
        </div>
        <section class="title-part">
            <div class="page-header">
                <?php
                if ( is_single()) : ?>
                    <h1 class="page-title">
                        <?php echo get_the_title(24); ?>
                    </h1>
                <?php  else:
                    single_post_title('<h1 class="page-title">', '</h1>');

                endif; ?>
            </div>
        </section>

    </header>
    <div id="content" class="site-content">
