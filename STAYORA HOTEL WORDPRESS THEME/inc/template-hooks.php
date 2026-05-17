<?php
/**
 * Stayora — Template Hooks
 * Wires action/filter hooks to template-part functions.
 * Child themes can remove or replace any hook without modifying core files.
 *
 * @package Stayora
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
   Document Head
------------------------------------------------------------------------- */
add_action( 'stayora_head', 'stayora_output_dark_mode_script', 1 );

function stayora_output_dark_mode_script(): void {
    // Inline script prevents flash of wrong theme (FOFT)
    ?>
    <script>
    (function(){
        var t = localStorage.getItem('stayora_theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        if (t === 'dark') { document.documentElement.setAttribute('data-theme','dark'); document.documentElement.classList.add('dark'); }
        document.cookie = 'stayora_theme=' + t + ';path=/;max-age=31536000';
    })();
    </script>
    <?php
}

/* -------------------------------------------------------------------------
   Before / After Content
------------------------------------------------------------------------- */
add_action( 'stayora_before_main_content', 'stayora_output_main_open' );
add_action( 'stayora_after_main_content',  'stayora_output_main_close' );

function stayora_output_main_open(): void {
    echo '<main id="main-content" class="site-main">';
}

function stayora_output_main_close(): void {
    echo '</main>';
}

/* -------------------------------------------------------------------------
   Accommodation Single Page
------------------------------------------------------------------------- */
add_action( 'stayora_accommodation_header', 'stayora_accommodation_hero',    10 );
add_action( 'stayora_accommodation_body',   'stayora_accommodation_gallery',  10 );
add_action( 'stayora_accommodation_body',   'stayora_accommodation_details',  20 );
add_action( 'stayora_accommodation_sidebar','stayora_accommodation_booking_widget', 10 );

function stayora_accommodation_hero(): void {
    stayora_part( 'accommodation/accommodation', 'hero' );
}

function stayora_accommodation_gallery(): void {
    stayora_part( 'accommodation/accommodation', 'gallery' );
}

function stayora_accommodation_details(): void {
    stayora_part( 'accommodation/accommodation', 'details' );
}

function stayora_accommodation_booking_widget(): void {
    stayora_part( 'booking/booking', 'widget' );
}

/* -------------------------------------------------------------------------
   404
------------------------------------------------------------------------- */
add_action( 'stayora_404_content', function() {
    stayora_part( 'sections/section', '404' );
} );
