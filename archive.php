<?php
/**
 * The template for displaying archive pages
 *
 * @package IBP_WooCommerce_Theme
 */
get_header();
?>

<main id="primary" class="site-main">
    <?php if (have_posts()) : ?>
        <header class="page-header">
            <?php
            the_archive_title('<h1 class="page-title">', '</h1>');
            the_archive_description('<div class="archive-description">', '</div>');
            ?>
        </header>

        <div class="archive-grid">
            <?php
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', get_post_type());
            endwhile;

            the_posts_pagination(array(
                'prev_text' => __('Anterior', 'ibp-woocommerce-theme'),
                'next_text' => __('Próximo', 'ibp-woocommerce-theme'),
            ));
            ?>
        </div>

    <?php else :
        get_template_part('template-parts/content', 'none');
    endif;
    ?>
</main>

<?php
get_sidebar();
get_footer();
