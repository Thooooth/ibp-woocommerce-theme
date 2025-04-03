<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package IBP_WooCommerce
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        if ('post' === get_post_type()) :
            ?>
            <div class="entry-meta">
                <span class="posted-on">
                    <?php
                    echo esc_html__('Publicado em: ', 'ibp-woocommerce');
                    echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_date() . '</a>';
                    ?>
                </span>
                <span class="byline">
                    <?php
                    echo esc_html__(' por ', 'ibp-woocommerce');
                    echo '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . get_the_author() . '</a>';
                    ?>
                </span>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php if (has_post_thumbnail() && !is_singular()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        if (is_singular()) :
            the_content(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Continue lendo<span class="screen-reader-text"> "%s"</span>', 'ibp-woocommerce'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Páginas:', 'ibp-woocommerce'),
                    'after'  => '</div>',
                )
            );
        else :
            the_excerpt();
            ?>
            <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Continue lendo', 'ibp-woocommerce'); ?></a>
        <?php endif; ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php if ('post' === get_post_type() && is_singular()) : ?>
            <div class="entry-categories">
                <?php
                echo esc_html__('Categorias: ', 'ibp-woocommerce');
                the_category(', ');
                ?>
            </div>
            <?php if (has_tag()) : ?>
                <div class="entry-tags">
                    <?php
                    echo esc_html__('Tags: ', 'ibp-woocommerce');
                    the_tags('', ', ', '');
                    ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->