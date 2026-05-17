<?php
/**
 * Stayora — Gutenberg / Block Editor Compatibility
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

// Remove core block patterns we don't need
add_action( 'after_setup_theme', function() {
    remove_theme_support( 'core-block-patterns' );
} );

// Add theme block patterns
add_action( 'init', 'stayora_register_block_patterns' );

function stayora_register_block_patterns(): void {
    if ( ! function_exists( 'register_block_pattern' ) ) return;

    register_block_pattern_category( 'stayora', [
        'label' => __( 'Stayora', 'stayora' ),
    ] );
}
