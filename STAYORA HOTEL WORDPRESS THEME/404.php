<?php
/**
 * Stayora — 404.php
 *
 * @package Stayora
 */

get_header();
?>
<?php do_action('stayora_before_main_content'); ?>

    <div class="pt-28">
        <?php do_action('stayora_404_content'); ?>
    </div>

<?php do_action('stayora_after_main_content'); ?>
<?php get_footer(); ?>
