<?php
/**
 * Stayora — Blog Card Component
 *
 * @package Stayora
 */

$cats = get_the_category();
?>

<article class="blog-card group" itemscope itemtype="https://schema.org/BlogPosting">
    <div class="blog-card__image">
        <?php if (has_post_thumbnail()) :
            the_post_thumbnail('stayora-blog-card',[
                'class'   => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
                'loading' => 'lazy',
                'itemprop'=> 'image',
            ]);
        else : ?>
            <div class="w-full h-full flex items-center justify-center" style="background-color:var(--color-surface-alt);">
                <?php echo stayora_icon('calendar','w-10 h-10'); ?>
            </div>
        <?php endif; ?>
        <?php if ($cats) : ?>
            <span class="blog-card__category"><?php echo esc_html($cats[0]->name); ?></span>
        <?php endif; ?>
    </div>
    <div class="blog-card__body">
        <h3 class="blog-card__title" itemprop="headline">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="blog-card__excerpt" itemprop="description">
            <?php echo wp_trim_words(get_the_excerpt(),18,'…'); ?>
        </p>
        <div class="blog-card__meta">
            <span itemprop="datePublished"><?php echo get_the_date(); ?></span>
            <span>&middot;</span>
            <span><?php printf(_n('%d min read','%d min read',max(1,ceil(str_word_count(get_the_content())/200)),'stayora'),max(1,ceil(str_word_count(get_the_content())/200))); ?></span>
            <a href="<?php the_permalink(); ?>" class="ml-auto flex items-center gap-1 hover:text-[color:var(--color-secondary)] transition-colors">
                <?php esc_html_e('Read','stayora'); ?>
                <?php echo stayora_icon('arrow-right','w-3.5 h-3.5'); ?>
            </a>
        </div>
    </div>
</article>
