<?php
/**
 * Stayora — Widgets
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

add_action( 'widgets_init', 'stayora_register_sidebars' );

function stayora_register_sidebars() {
    $config = [
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-8">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title font-display text-xl mb-4">',
        'after_title'   => '</h4>',
    ];

    register_sidebar( array_merge( $config, [
        'name'        => __( 'Blog Sidebar', 'stayora' ),
        'id'          => 'sidebar-blog',
        'description' => __( 'Widgets shown in the blog sidebar.', 'stayora' ),
    ] ) );

    register_sidebar( array_merge( $config, [
        'name'        => __( 'Footer Column 1', 'stayora' ),
        'id'          => 'footer-1',
        'description' => __( 'First footer widget area.', 'stayora' ),
    ] ) );

    register_sidebar( array_merge( $config, [
        'name'        => __( 'Footer Column 2', 'stayora' ),
        'id'          => 'footer-2',
        'description' => __( 'Second footer widget area.', 'stayora' ),
    ] ) );

    register_sidebar( array_merge( $config, [
        'name'        => __( 'Accommodation Sidebar', 'stayora' ),
        'id'          => 'sidebar-accommodation',
        'description' => __( 'Widgets on accommodation listing page.', 'stayora' ),
    ] ) );
}
