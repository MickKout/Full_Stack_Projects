<?php

/**
 * CreatorPress functions and theme setup.
 *
 * @package CreatorPress
 */

if ( ! function_exists( 'creatorpress_setup' ) ) {
    function creatorpress_setup() {
        load_theme_textdomain( 'creatorpress', get_template_directory() . '/languages' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'custom-logo', array(
            'height'      => 80,
            'width'       => 300,
            'flex-height' => true,
            'flex-width'  => true,
        ) );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
        add_theme_support( 'responsive-embeds' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'editor-styles' );
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'editor-font-sizes', array(
            array(
                'name' => __( 'Small', 'creatorpress' ),
                'size' => 14,
                'slug' => 'small'
            ),
            array(
                'name' => __( 'Normal', 'creatorpress' ),
                'size' => 18,
                'slug' => 'normal'
            ),
            array(
                'name' => __( 'Large', 'creatorpress' ),
                'size' => 24,
                'slug' => 'large'
            ),
            array(
                'name' => __( 'XL', 'creatorpress' ),
                'size' => 32,
                'slug' => 'xl'
            )
        ) );

        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'creatorpress' ),
            'footer'  => __( 'Footer Menu', 'creatorpress' ),
        ) );

        add_theme_support( 'customize-selective-refresh-widgets' );
    }
}
add_action( 'after_setup_theme', 'creatorpress_setup' );

/**
 * Register widget area.
 */
function creatorpress_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Footer Newsletter', 'creatorpress' ),
        'id'            => 'footer-newsletter',
        'description'   => __( 'Footer newsletter / CTA widget area.', 'creatorpress' ),
        'before_widget' => '<section class="footer-widget">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="text-sm font-semibold tracking-wide uppercase">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'creatorpress_widgets_init' );

/**
 * Enqueue theme assets.
 */
function creatorpress_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );
    $style_path = get_theme_file_path( '/assets/css/style.css' );
    $style_url  = get_theme_file_uri( '/assets/css/style.css' );

    if ( file_exists( $style_path ) ) {
        wp_enqueue_style( 'creatorpress-style', $style_url, array(), filemtime( $style_path ) );
    }

    wp_enqueue_script( 'creatorpress-theme', get_theme_file_uri( '/assets/js/theme.js' ), array(), $theme_version, true );
    wp_localize_script( 'creatorpress-theme', 'creatorpressSettings', array(
        'darkMode' => get_theme_mod( 'creatorpress_dark_mode', 'light' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'creatorpress_scripts' );

/**
 * Add editor styles.
 */
function creatorpress_editor_styles() {
    add_editor_style( 'assets/css/style.css' );
}
add_action( 'admin_init', 'creatorpress_editor_styles' );

/**
 * Register customizer settings.
 */
function creatorpress_customizer_register( $wp_customize ) {
    $wp_customize->add_section( 'creatorpress_cta_section', array(
        'title'    => __( 'CreatorPress CTA', 'creatorpress' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'creatorpress_cta_text', array(
        'default'           => __( 'Start your premium online presence', 'creatorpress' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'creatorpress_cta_text', array(
        'label'   => __( 'Homepage CTA headline', 'creatorpress' ),
        'section' => 'creatorpress_cta_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'creatorpress_cta_button', array(
        'default'           => __( 'Book a call', 'creatorpress' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'creatorpress_cta_button', array(
        'label'   => __( 'CTA button label', 'creatorpress' ),
        'section' => 'creatorpress_cta_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'creatorpress_cta_url', array(
        'default'           => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'creatorpress_cta_url', array(
        'label'   => __( 'CTA button URL', 'creatorpress' ),
        'section' => 'creatorpress_cta_section',
        'type'    => 'url',
    ) );
}
add_action( 'customize_register', 'creatorpress_customizer_register' );

/**
 * Return CTA button text from customizer or fallback.
 */
function creatorpress_get_cta_text() {
    return get_theme_mod( 'creatorpress_cta_text', __( 'Start your premium online presence', 'creatorpress' ) );
}

/**
 * Output a safe CTA button label.
 */
function creatorpress_cta_label() {
    echo esc_html( get_theme_mod( 'creatorpress_cta_button', __( 'Book a call', 'creatorpress' ) ) );
}

/**
 * Custom excerpt fallback.
 */
function creatorpress_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'creatorpress_excerpt_length', 999 );

/**
 * Use valid body classes.
 */
function creatorpress_body_classes( $classes ) {
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    if ( ! is_singular() ) {
        $classes[] = 'list-view';
    }

    return $classes;
}
add_filter( 'body_class', 'creatorpress_body_classes' );
