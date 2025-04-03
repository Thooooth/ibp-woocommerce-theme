<?php
/**
 * The template for displaying comments
 *
 * @package IBP_WooCommerce_Theme
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('Um comentário em "%1$s"', 'ibp-woocommerce-theme'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_n('%1$s comentário em "%2$s"', '%1$s comentários em "%2$s"', $comment_count, 'ibp-woocommerce-theme')),
                    number_format_i18n($comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comentários estão fechados.', 'ibp-woocommerce-theme'); ?></p>
            <?php
        endif;
    endif;

    comment_form();
    ?>
</div>

