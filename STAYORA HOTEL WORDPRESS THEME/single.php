<?php
/**
 * Stayora — single.php
 * Single post template (blog / journal).
 *
 * @package Stayora
 */

// Dispatch accommodation single to its own template
if (is_singular('accommodation')) {
    get_template_part('templates/single','accommodation');
    return;
}

get_header();
?>

<?php do_action('stayora_before_main_content'); ?>

    <div class="pt-28" style="background-color:var(--color-surface);">

        <!-- Post Header -->
        <header class="py-14 px-4" style="background-color:var(--color-surface-alt);border-bottom:1px solid var(--color-border);">
            <div class="stayora-container-narrow">
                <?php stayora_breadcrumb(); ?>
                <div class="mt-6">
                    <?php
                    $cats = get_the_category();
                    if ($cats) : ?>
                        <a href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>"
                           class="section-label hover:opacity-80">
                            <?php echo esc_html($cats[0]->name); ?>
                        </a>
                    <?php endif; ?>
                    <h1 class="font-display font-light mt-2 mb-5"
                        style="font-size:clamp(2rem,4vw,3rem);line-height:1.1;color:var(--color-text);">
                        <?php the_title(); ?>
                    </h1>
                    <div class="flex flex-wrap items-center gap-5 text-sm" style="color:var(--color-text-muted);">
                        <span class="flex items-center gap-2">
                            <?php echo get_avatar(get_the_author_meta('ID'),32,'','',['class'=>'rounded-full']); ?>
                            <?php the_author(); ?>
                        </span>
                        <span><?php echo get_the_date(); ?></span>
                        <span><?php printf(_n('%d min read','%d min read',max(1,ceil(str_word_count(get_the_content())/200)),'stayora'),max(1,ceil(str_word_count(get_the_content())/200))); ?></span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="stayora-container-narrow px-0 sm:px-6 lg:px-8">
                <div class="overflow-hidden" style="max-height:520px;">
                    <?php the_post_thumbnail('stayora-hero',['class'=>'w-full object-cover','loading'=>'eager']); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Article Content -->
        <article class="py-12 px-4">
            <div class="stayora-container-narrow">
                <div class="prose prose-lg max-w-none"
                     style="color:var(--color-text);--tw-prose-links:var(--color-secondary);">
                    <?php the_content(); ?>
                </div>

                <!-- Pagination inside post -->
                <div class="mt-10">
                    <?php wp_link_pages(['before'=>'<div class="page-links flex gap-2">','after'=>'</div>']); ?>
                </div>

                <!-- Tags -->
                <?php $tags = get_the_tags(); if ($tags) : ?>
                    <div class="flex flex-wrap gap-2 mt-10 pt-8" style="border-top:1px solid var(--color-border);">
                        <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="badge hover:bg-[color:var(--color-secondary)] hover:text-[color:var(--color-cta-text)] transition-colors">
                                #<?php echo esc_html($tag->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Author box -->
                <div class="mt-12 p-6 flex gap-5" style="background-color:var(--color-surface-alt);border:1px solid var(--color-border);">
                    <?php echo get_avatar(get_the_author_meta('ID'),72,'','',['class'=>'rounded-full flex-shrink-0']); ?>
                    <div>
                        <div class="font-medium mb-1" style="color:var(--color-text);"><?php the_author(); ?></div>
                        <p class="text-sm leading-relaxed" style="color:var(--color-text-muted);">
                            <?php the_author_meta('description'); ?>
                        </p>
                    </div>
                </div>

                <!-- Post Navigation -->
                <nav class="mt-12 grid grid-cols-2 gap-4" aria-label="<?php esc_attr_e('Post navigation','stayora'); ?>">
                    <?php
                    $prev = get_previous_post();
                    $next = get_next_post();
                    if ($prev) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev)); ?>"
                           class="p-4 group" style="border:1px solid var(--color-border);">
                            <span class="block text-xs uppercase tracking-widest mb-2" style="color:var(--color-text-muted);">&larr; <?php esc_html_e('Previous','stayora'); ?></span>
                            <span class="font-display text-lg group-hover:text-[color:var(--color-secondary)] transition-colors" style="color:var(--color-text);">
                                <?php echo esc_html(get_the_title($prev)); ?>
                            </span>
                        </a>
                    <?php else : ?><div></div><?php endif; ?>
                    <?php if ($next) : ?>
                        <a href="<?php echo esc_url(get_permalink($next)); ?>"
                           class="p-4 group text-right" style="border:1px solid var(--color-border);">
                            <span class="block text-xs uppercase tracking-widest mb-2" style="color:var(--color-text-muted);"><?php esc_html_e('Next','stayora'); ?> &rarr;</span>
                            <span class="font-display text-lg group-hover:text-[color:var(--color-secondary)] transition-colors" style="color:var(--color-text);">
                                <?php echo esc_html(get_the_title($next)); ?>
                            </span>
                        </a>
                    <?php endif; ?>
                </nav>

                <!-- Comments -->
                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="mt-12">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>

            </div><!-- /.container-narrow -->
        </article>

    </div>

<?php do_action('stayora_after_main_content'); ?>
<?php get_footer(); ?>
