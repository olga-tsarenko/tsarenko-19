<?php

$sisSocialShare = new Shapla_Settings_API;

// Add settings page
$sisSocialShare->add_menu([
    'page_title'   => __('Social Share Buttons', 'sis-social-share'),
    'menu_title'   => __('Social Share Buttons', 'sis-social-share'),
    'capability'   => 'manage_options',
    'menu_slug'    => 'sis-social-share',
    'option_name'  => 'sis_social_share',
]);

// Add settings page tab
$sisSocialShare->add_tab([
    'id' => 'general',
    'title' => __('General', 'sis-social-share'),
]);
$sisSocialShare->add_tab([
    'id' => 'site',
    'title' => __('Site Buttons', 'sis-social-share'),
]);
$sisSocialShare->add_tab([
    'id' => 'post',
    'title' => __('Post Buttons', 'sis-social-share'),
]);
$sisSocialShare->add_tab([
    'id' => 'color',
    'title' => __('Buttons Size &amp; Color', 'sis-social-share'),
]);

// Add settings page fields
$sisSocialShare->add_field([
    'id'    => 'enable_for_site',
    'type'  => 'checkbox',
    'name'  => __('Enable for Site', 'sis-social-share'),
    'desc'  => __('Enable this option to show the social share buttons on site.', 'sis-social-share'),
    'std'   => 0,
    'tab'   => 'general'
]);
$sisSocialShare->add_field([
    'id'    => 'enable_for_posts',
    'type'  => 'checkbox',
    'name'  => __('Enable for Post', 'sis-social-share'),
    'desc'  => __('Enable this option to show the social share buttons below each post.', 'sis-social-share'),
    'std'   => 1,
    'tab'   => 'general'
]);

$sisSocialShare->add_field([
    'id'    => 'site_buttons',
    'type'  => 'multi_checkbox',
    'name'  => __('Share buttons for site', 'sis-social-share'),
    'std'   => array( 'digg', 'facebook', 'google_plus', 'linkedin', 'tumblr', 'pinterest', 'reddit', 'stumble', 'twitter', ),
    'desc'  => __('Check which buttons you want to show on site.', 'sis-social-share'),
    'options' => array(
        'digg'   		=> __('Digg', 'sis-social-share'),
        'facebook'   	=> __('Facebook', 'sis-social-share'),
        'google_plus' 	=> __('Google Plus', 'sis-social-share'),
        'linkedin'   	=> __('Linkedin', 'sis-social-share'),
        'tumblr'   		=> __('Tumblr', 'sis-social-share'),
        'pinterest'   	=> __('Pinterest', 'sis-social-share'),
        'reddit'   		=> __('Reddit', 'sis-social-share'),
        'stumble'   	=> __('Stumble Upon', 'sis-social-share'),
        'twitter'   	=> __('Twitter', 'sis-social-share'),
    ),
    'tab'   => 'site'
]);
$sisSocialShare->add_field([
    'id'    => 'site_buttons_position',
    'type'  => 'radio',
    'name'  => __('Buttons Position', 'sis-social-share'),
    'std'   => 'left',
    'options' => array(
        'left'   	=> __('Left', 'sis-social-share'),
        'right'   	=> __('Right', 'sis-social-share'),
    ),
    'tab'   => 'site',
    'desc'  => __('Choose where you want to show buttons. Left or Right', 'sis-social-share'),
]);
$sisSocialShare->add_field([
    'id'    => 'site_buttons_from_top',
    'type'  => 'text',
    'name'  => __('Buttons position from top', 'sis-social-share'),
    'desc'  => __('Write button position from top in pixels. Example: 100px', 'sis-social-share'),
    'std'   => '50px',
    'tab'   => 'site'
]);

$sisSocialShare->add_field([
    'id'    => 'post_buttons',
    'type'  => 'multi_checkbox',
    'name'  => __('Share buttons for post', 'sis-social-share'),
    'std'   => array( 'digg', 'facebook', 'google_plus', 'linkedin', 'tumblr', 'pinterest', 'reddit', 'stumble', 'twitter', ),
    'options' => array(
        'digg'   		=> __('Digg', 'sis-social-share'),
        'facebook'   	=> __('Facebook', 'sis-social-share'),
        'google_plus' 	=> __('Google Plus', 'sis-social-share'),
        'linkedin'   	=> __('Linkedin', 'sis-social-share'),
        'tumblr'   		=> __('Tumblr', 'sis-social-share'),
        'pinterest'   	=> __('Pinterest', 'sis-social-share'),
        'reddit'   		=> __('Reddit', 'sis-social-share'),
        'stumble'   	=> __('Stumble Upon', 'sis-social-share'),
        'twitter'   	=> __('Twitter', 'sis-social-share'),
    ),
    'desc'  => __('Check which social share buttons you want to show below each post.', 'sis-social-share'),
    'tab'   => 'post'
]);

$sisSocialShare->add_field([
    'id'    => 'color_digg',
    'type'  => 'color',
    'name'  => __('Digg', 'sis-social-share'),
    'std'   => '#005be2',
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'color_facebook',
    'type'  => 'color',
    'name'  => __('Facebook', 'sis-social-share'),
    'std'   => '#3b5998',
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'color_google_plus',
    'type'  => 'color',
    'name'  => __('Google Plus', 'sis-social-share'),
    'std'   => '#dd4b39',
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'color_linkedin',
    'type'  => 'color',
    'name'  => __('Linkedin', 'sis-social-share'),
    'std'   => '#007bb6',
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'color_tumblr',
    'type'  => 'color',
    'name'  => __('Tumblr', 'sis-social-share'),
    'std'   => '#32506d',
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'color_pinterest',
    'type'  => 'color',
    'name'  => __('Pinterest', 'sis-social-share'),
    'std'   => '#cb2027',
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'color_reddit',
    'type'  => 'color',
    'name'  => __('Reddit', 'sis-social-share'),
    'std'   => '#ff4500',
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'color_stumble',
    'type'  => 'color',
    'name'  => __('Stumble Upon', 'sis-social-share'),
    'std'   => '#EB4823',
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'color_twitter',
    'type'  => 'color',
    'name'  => __('Twitter', 'sis-social-share'),
    'std'   => '#00aced',
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'color_icon',
    'type'  => 'color',
    'name'  => __('Icon Color', 'sis-social-share'),
    'desc'  => __('This color will be used for icon and background color of icon on hover.', 'sis-social-share'),
    'std'   => '#ffffff',
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'buttons_size',
    'type'  => 'number',
    'name'  => __('Icon size', 'sis-social-share'),
    'std'   => 28,
    'tab'   => 'color'
]);
$sisSocialShare->add_field([
    'id'    => 'buttons_padding',
    'type'  => 'number',
    'name'  => __('Padding around icon', 'sis-social-share'),
    'std'   => 10,
    'tab'   => 'color'
]);
